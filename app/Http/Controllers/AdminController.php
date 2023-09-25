<?php

namespace App\Http\Controllers;


use App\User;
use App\Game;
use App\Withdraw;
use App\Settings;
use Carbon\Carbon;
use Validator;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class AdminController extends Controller
{

    /*
     * Главная
     */
    public function index()
    {
        /*
         * Статистика
         */
		$all_win = Game::where('status', 1)->sum('win');
		$all_games = Game::where('status', 1)->count();
		$all_payed = \DB::table('payments')->where('status', 1)->sum('amount');
		$all_with = \DB::table('withdraw')->where('status', 1)->sum('amount');
		$pay_today = \DB::table('payments')->where('created_at', '>=', Carbon::today())->where('status', 1)->where('type', 0)->sum('amount');
		$pay_week = \DB::table('payments')->where('created_at', '>=', Carbon::now()->subDays(7))->where('type', 0)->where('status', 1)->sum('amount');
		$pay_month = \DB::table('payments')->where('created_at', '>=', Carbon::now()->subDays(30))->where('status', 1)->where('type', 0)->sum('amount');
		$last_games = Game::where('status', 1)->orderBy('id', 'desc')->limit(7)->get();
		foreach($last_games as $l)
		{
			$l->user = User::where('id', $l->user_id)->first();
		}
		$last_pays = \DB::table('payments')->where('status', 1)->orderBy('id', 'desc')->limit(5)->get();
		foreach($last_pays as $lp)
		{
			$lp->user = User::where('id', $lp->user)->first();
		}
		$last_withs = \DB::table('withdraw')->where('status', 0)->orderBy('id', 'desc')->limit(7)->get();
		foreach($last_withs as $lw)
		{
			$lw->user = User::where('id', $lw->user_id)->first();
		}
        return view('admin.index', compact('all_win', 'all_games', 'all_payed', 'all_with', 'pay_today', 'pay_week', 'pay_month', 'last_games', 'last_pays', 'last_withs'));
    }

    /*
     * Настройки
     */
    public function settings()
    {
		$settings = Settings::where('id', 1)->first();
        return view('admin.settings', compact('settings'));
    }

    /*
     * Сохраняем настройки
     */
    public function saveSettings(Request $r)
    {
        $settings = Settings::where('id', 1)->first();
		$settings->update([
            'chance' => $r->chance,
            'yt_chance' => $r->yt_chance,
            'promo_sum' => $r->promo_sum,
            'promo_percent' => $r->promo_percent,
            'min_with' => $r->min_with,
            'min_bet' => $r->min_bet,
            'fk_id' => $r->fk_id,
            'fk_secret1' => $r->fk_secret1,
            'fk_secret2' => $r->fk_secret2
        ]);
        return redirect('/admin/settings');
    }

    /*
     * Последние открытия
     */
    public function lastOpen()
    {
        $opens = Game::orderBy('id', 'desc')->get();
        foreach ($opens as $live) {
            $live->user = User::where('id', $live->user_id)->first();
        }
        return view('admin.lastOpen', compact('opens'));
    }

    public function lastWithdraw()
    {
        $opens = \DB::table('withdraw')->orderBy('id', 'asc')->where('status', 0)->get();
        foreach ($opens as $live) {
            $live->user = User::where('id', $live->user_id)->first();
        }
        return view('admin.lastWithdraw', compact('opens'));
    }

    public function acceptWithdraw($id)
    {
        $withdraw = Withdraw::where('id', $id)->first();
        if (!is_null($withdraw)) $withdraw->update(['status' => 1]);
        return \Redirect::back();
    }

    public function declineWithdraw($id)
    {
        $withdraw = Withdraw::where('id', $id)->first();
        if (!is_null($withdraw)) $withdraw->update(['status' => 2]);
        $user = User::where('id', $withdraw->user_id)->first();
        if (!is_null($user)) $user->update(['money' => $user->money + $withdraw->amount]);
        return \Redirect::back();
    }

    public function lastOrders()
    {
        $opens = \DB::table('payments')->orderBy('id', 'desc')->where('status', 1)->get();
        foreach ($opens as $live) {
            $live->user = User::where('id', $live->user)->first();
        }
        return view('admin.lastOrders', compact('opens'));
    }


    public function users()
    {
        // $users = User::orderBy('id', 'desc')->get();
		// foreach($users as $u)
		// {
		// 	$u->countGames = Game::where('user_id', $u->id)->where('status',1)->count();
		// 	$u->winGames = Game::where('user_id', $u->id)->where('status', 1)->sum('win');
		// }
        return view('admin.users');
    }

    public function usersTable(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length");

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column'];
        $tempOrder = 0;
        if($columnIndex == 3 || $columnIndex == 4) {
            $tempOrder = $columnIndex;
            $columnIndex = 0;
        }
        $columnName = $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];
        $searchValue = $search_arr['value'];

        $totalRecords = User::select('count(*) as allcount')->count();
        $totalRecordswithFilter = User::select('count(*) as allcount')->where('username', 'like', '%' . $searchValue . '%')->count();

        $records = User::orderBy($columnName, $columnSortOrder)
            ->where('users.username', 'like', '%' .$searchValue . '%')
            ->select('users.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();
        
        foreach($records as $record) {
            $record->countGames = Game::where('user_id', $record->id)->where('status',1)->count();
			$record->winGames = Game::where('user_id', $record->id)->where('status', 1)->sum('win');
            $record->winGames = isset($record->winGames) ? $record->winGames : 0;
            $record->action = '<a href="/admin/user/'.$record->id.'" class="table-action-btn">';
            $record->action .= 'Editar <i class="md md-edit"></i>';
            $record->action .= '</a>';
            $data_arr[] = $record;
        }

        if($tempOrder != 0) {
            if ($tempOrder == 3) {
                if($columnSortOrder == "asc") {
                    usort($data_arr, function($a, $b) {
                        if ($a->countGames == $b->countGames) {
                            return 0;
                        }
                        return ($a->countGames < $b->countGames) ? -1 : 1;
                    });
                } else {
                    usort($data_arr, function($a, $b) {
                        if ($a->countGames == $b->countGames) {
                            return 0;
                        }
                        return ($a->countGames > $b->countGames) ? -1 : 1;
                    });
                }
            } else if ($tempOrder == 4) {
                if($columnSortOrder == "asc") {
                    usort($data_arr, function($a, $b) {
                        if ($a->winGames == $b->winGames) {
                            return 0;
                        }
                        return ($a->winGames < $b->winGames) ? -1 : 1;
                    });
                } else {
                    usort($data_arr, function($a, $b) {
                        if ($a->winGames == $b->winGames) {
                            return 0;
                        }
                        return ($a->winGames > $b->winGames) ? -1 : 1;
                    });
                }
            }
        }

        foreach($data_arr as $r) {
            \Log::debug($r->countGames);
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr,
            "tempOrder" => $tempOrder
        );

        echo json_encode($response);
        exit;
    }

    public function user($id)
    {
        $user = User::where('id', $id)->first();
		$user->countGames = Game::where('user_id', $user->id)->where('status',1)->count();
		$user->winGames = Game::where('user_id', $user->id)->where('status', 1)->sum('win');
        return view('admin.user', compact('user'));
    }

	
    public function saveUser(Request $r)
    {
        $user = User::where('id', $r->id)->first();
        $cpf = preg_replace('/[^0-9]/', '', $r->cpf);
        if (is_null($user)) \Redirect::back();
        $user->update([
            'username' => $r->username,
            'cpf' => $cpf,
            'pix' => $r->pix,
            'avatar' => $r->avatar,
            'money' => $r->money,
			'is_admin' => $r->is_admin,
            'is_yt' => $r->is_yt,
            'ref_code' => $r->ref_code,
            'ref_use' => $r->ref_use,
			'login2' => $r->login2
        ]);
        return \Redirect::back();
    }

    public function password($id)
    {
        $user = User::find($id);
        return view('admin.user_password', compact('user'));
    }

    public function passwordStore(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'password' => 'required|min:6',
        ]);

        if($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();

        $user = User::find($id);
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->withSuccess('Senha Alterada com Sucesso!');
    }
}