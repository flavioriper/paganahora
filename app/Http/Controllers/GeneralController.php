<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\User;
use App\Settings;
use App\Game;
use Auth;
use DB;
use Validator;
use Illuminate\Support\Facades\Cache;


class GeneralController extends Controller
{
    public function index()
	{
		return view('pages.index');
	}
		public function get_jackpots()
	{
		$pot_1 = Cache::get('pot_1');
		$pot_2 = Cache::get('pot_2');
		$pot_3 = Cache::get('pot_3');

		if (!Cache::has('pot_1') || !Cache::has('pot_2') || !Cache::has('pot_3')) {
			self::flush_jackpot();
			$pot_1 = 0;
			$pot_2 = 0;
			$pot_3 = 0;
		}

		$jackpot = [
			'pot_1' => $pot_1,
			'pot_2' => $pot_2,
			'pot_3' => $pot_3,
		];
		return json_encode($jackpot);
	}
    private static function increment_jackpot($bet)
	{
		$pot_1 = $bet * 0.1;
		$pot_2 = $pot_1 * 0.3;
		$pot_3 = $pot_1 * 0.2;

		Cache::put('pot_1', Cache::get('pot_1') + $pot_1, $seconds = 10);
		Cache::put('pot_2', Cache::get('pot_2') + $pot_2, $seconds = 10);
		Cache::put('pot_3', Cache::get('pot_3') + $pot_3, $seconds = 10);

		return true;
	}
		private static function flush_jackpot()
	{
		Cache::flush();

		Cache::forever('pot_1', 0);
		Cache::forever('pot_2', 0);
		Cache::forever('pot_3', 0);

		return true;
	}
	public function start(Request $r)
	{
		if(Auth::guest())
		{
			return response('{"gameAmount":["\u041d\u0435\u0434\u043e\u0441\u0442\u0430\u0442\u043e\u0447\u043d\u043e \u0441\u0440\u0435\u0434\u0441\u0442\u0432!"]}', 422);
		}
		else
		{
			if(Auth::user()->money < $r->gameAmount)
			{
				return response('{"gameAmount":["\u041d\u0435\u0434\u043e\u0441\u0442\u0430\u0442\u043e\u0447\u043d\u043e \u0441\u0440\u0435\u0434\u0441\u0442\u0432!"]}', 422);
			}
			else
			{
				$bet = $r->gameAmount;
				$user = User::where('id', Auth::user()->id)->first();
				$user->money = $user->money - $bet;
				$user->save();
				$settings = Settings::where('id', 1)->first();
				if(Auth::user()->is_yt == 1)
				{
					$chance = $settings->yt_chance;
				}
				else
				{
					$chance = $settings->chance;
				}
				$pro = mt_rand(1,100);
				if($pro >= $chance)
				{
					$multiply1 = 2;
					$multiply2 = 5;
					$multiply3 = 10;
					$cell_1 = $bet*$multiply1;
					$cell_2 = $bet*$multiply2;
					$cell_3 = $bet*$multiply3;
					$cells = array($cell_1, $cell_2, $cell_3);
					shuffle($cells);
					
					$insert = DB::table('games')->insertGetId([
						'bet' => $bet,
						'user_id' => Auth::user()->id,
						'type' => $r->gameType,
						'cell_1' => $cells[0],
						'cell_2' => $cells[1],
						'cell_3' => $cells[2],
						'win' => $bet*0.1,
						'status' => 0
					]);

					self::increment_jackpot($bet);
					return json_encode(array("type" => $r->gameType, "bet" => $bet, "game_id" => $insert, "cell_1" => $cells[0], "cell_2" => $cells[1], "cell_3" => $cells[2]));
				}
				else
				{
					$pro2 = mt_rand(1,100);
					if($pro2 >= $chance) // Se o aleatório for maior que a chance, criaremos um jogo com 2 cartas idênticas
					{
						$multiply1 = array(2,5,10);	// Crie o primeiro multiplicador
						shuffle($multiply1);
						
						$pro5 = mt_rand(1,100); // Criando multiplicadores de chance
						
						if($pro5 <= $chance)  // Se a chance de multiplicadores for menor que a chance
						{
							$multiply2 = array(2,5,10);
							shuffle($multiply2); // distribuímos multiplicadores
						}
						if($pro5 > $chance) // Se não, então dara perda para casa
						{
							$multiply2 = array(2,5);
							shuffle($multiply2); 
						}
						
						
						$cell_1 = $bet*$multiply1[0]; // Multiplicamos a aposta por um determinado primeiro multiplicador
						$cell_2 = $bet*$multiply2[0]; // Multiplique pelo segundo fator
						$cell_3 = $bet*$multiply2[0]; // Multiplique pelo segundo fator
						
 						if(($cell_1 == $cell_2) && ($cell_2 == $cell_3)) // Se todos os números forem iguais, então
						{
							$insert = DB::table('games')->insertGetId([
								'bet' => $bet,
								'user_id' => Auth::user()->id,
								'type' => $r->gameType,
								'cell_1' => $cell_1,
								'cell_2' => $cell_2,
								'cell_3' => $cell_3,
								'win' => $cell_3,
								'status' => 0
							]);
							return json_encode(array("type" => $r->gameType, "bet" => $bet, "game_id" => $insert, "cell_1" => $cell_1, "cell_2" => $cell_2, "cell_3" => $cell_3));
						}
						else // Se um número não for o mesmo
						{
							$cells = array($cell_1, $cell_2, $cell_3);
							shuffle($cells);
							$pro3 = mt_rand(1,100); // contando a chance
							if($pro3 <= $chance) 
							{
								$cell_4 = $bet*$multiply2[0]; // Se tudo estiver errado, multiplicamos pelo mesmo número que dois
								$insert = DB::table('games')->insertGetId([
									'bet' => $bet,
									'user_id' => Auth::user()->id,
									'type' => $r->gameType,
									'cell_1' => $cells[0],
									'cell_2' => $cells[1],
									'cell_3' => $cells[2],
									'cell_4' => $cell_4,
									'may_win' => $cell_4,
									'status' => 0
								]);
								self::increment_jackpot($bet);
								return json_encode(array("type" => $r->gameType, "bet" => $bet, "game_id" => $insert, "cell_1" => $cells[0], "cell_2" => $cells[1], "cell_3" => $cells[2]));
							}
							else
							{
								$cell_4 = $bet*$multiply2[1]; // Se não, então multiplique por outro número
								$insert = DB::table('games')->insertGetId([
									'bet' => $bet,
									'user_id' => Auth::user()->id,
									'type' => $r->gameType,
									'cell_1' => $cells[0],
									'cell_2' => $cells[1],
									'cell_3' => $cells[2],
									'cell_4' => $cell_4,
									'may_win' => $bet*0.1,
									'status' => 0
								]);
								self::increment_jackpot($bet);
								return json_encode(array("type" => $r->gameType, "bet" => $bet, "game_id" => $insert, "cell_1" => $cells[0], "cell_2" => $cells[1], "cell_3" => $cells[2]));
							}
							
						} 
					}
					else
					{
						$pro5 = mt_rand(1,100); // Criando multiplicadores de chance
						
						if($pro5 < $chance)  // Se a chance de multiplicadores for menor que a chance
						{
							$multiply2 = 2;
						}
						elseif($pro5 > $chance) // Se não, dará perda
						{
							$multiply2 = 5;
						}
						elseif($pro == $chance)
						{
							$multiply = 10;
						}
						
						$cell_1 = $bet*$multiply2; // Multiplicamos a aposta por um determinado primeiro multiplicador
						$cell_2 = $bet*$multiply2; // Multiplique pelo segundo fator
						$cell_3 = $bet*$multiply2; // Multiplique pelo segundo fator
						
						$cells = array($cell_1, $cell_2, $cell_3);
						shuffle($cells);

						$insert = DB::table('games')->insertGetId([
							'bet' => $bet,
							'user_id' => Auth::user()->id,
							'type' => $r->gameType,
							'cell_1' => $cells[0],
							'cell_2' => $cells[1],
							'cell_3' => $cells[2],
							'win' => $cells[0],
							'status' => 0
						]);
						return json_encode(array("type" => $r->gameType, "bet" => $bet, "game_id" => $insert, "cell_1" => $cells[0], "cell_2" => $cells[1], "cell_3" => $cells[2]));
					}
				}
			}
		}
	}
	public function game_continue(Request $r)
	{
		$game = Game::where('id', $r->id)->first();
		if($game == false)
		{
			return response('{"gameAmount":["Jogo não encontrado!"]}', 422);
		}
		else
		{
			if($game->status != 0)
			{
				return response('{"gameAmount":["Jogo Finalizado!"]}', 422);
			}
			if(Auth::guest())
			{
				return response('{"gameAmount":["Você precisa estra logado para esta ação!"]}', 422);
			}
			$user = User::where('id', Auth::user()->id)->first();
			$user->money = $user->money - $game->bet/2;
			$game->win = $game->may_win;
			$game->save();
			$user->save();
			return json_encode(array("type" => 1, "cell_4" => (int)$game->cell_4));
		}
		
	}
	public function game_end(Request $r)
	{
		if(!isset($r->id) || empty($r->id) || $r->id == '')
		{
			return response('{"gameAmount":["Erro, ID do jogo não transferido!"]}', 422);
		}
		else
		{
			$game = Game::where('id', $r->id)->first();
			if($game == false)
			{
				return response('{"gameAmount":["Jogo não encontrado!"]}', 422);
			}
			else
			{
				if($game->win == NULL)
				{
					$game->win = $game->bet*0.1;
					$win = $game->bet*0.1;
				}
				else
				{
					$win = $game->win;
				}
				$game->status = 1;
				$game->save();
				$user = User::where('id', Auth::user()->id)->first();
				$user->money = $user->money + $game->win;
				$user->save();
				return json_encode(array("win" => (int)$win));
			}
		}
	}
	public function stats()
	{
		$users = User::count();
		$win = Game::where('status', 1)->sum('win');
		$games = Game::where('status', 1)->count();
		return json_encode(array("users" => $users, "win" => $win, "drops" => $games));
	}
	public function get_drop()
	{
		$game = Game::where('status', 1)->orderBy('id', 'desc')->limit(25)->get();
		foreach($game as $g)
		{
			if($g->win < 10)
			{
				$g->planet = 1;
			}
			if($g->win >= 10 && $g->win < 20)
			{
				$g->planet = 2;
			}
			elseif($g->win >= 20 && $g->win < 50)
			{
				$g->planet = 3;
			}
			elseif($g->win >= 50 && $g->win < 100)
			{
				$g->planet = 4;
			}
			elseif($g->win >= 100 && $g->win < 200)
			{
				$g->planet = 5;
			}
			elseif($g->win >= 200 && $g->win < 500)
			{
				$g->planet = 6;
			}
			elseif($g->win >= 500 && $g->win < 1000)
			{
				$g->planet = 7;
			}
			elseif($g->win >= 1000 && $g->win < 10000)
			{
				$g->planet = 8;
			}
			elseif($g->win >= 10000)
			{
				$g->planet = 9;
			}
			$g->user = User::where('id', $g->user_id)->first();
		}
		$drops = array();
		foreach($game as $p)
		{
			$info = array("planet" => $p->planet, "amount" => $p->win, "link" => '/user/'.$p->user_id, "image" => $p->user->avatar);
			array_push($drops, $info);
		}
		return json_encode(array_reverse($drops));
	}
	public function drop(Request $r)
	{
		if(!isset($r->id))
		{
			return "Nenhum resultado encontrado";
		}
		$g = Game::where('id', $r->id)->first();
		if($g->win < 10)
		{
			$g->planet = 1;
		}
		if($g->win >= 10 && $g->win < 20)
		{
			$g->planet = 2;
		}
		elseif($g->win >= 20 && $g->win < 50)
		{
			$g->planet = 3;
		}
		elseif($g->win >= 50 && $g->win < 100)
		{
			$g->planet = 4;
		}
		elseif($g->win >= 100 && $g->win < 200)
		{
			$g->planet = 5;
		}
		elseif($g->win >= 200 && $g->win < 500)
		{
			$g->planet = 6;
		}
		elseif($g->win >= 500 && $g->win < 1000)
		{
			$g->planet = 7;
		}
		elseif($g->win >= 1000 && $g->win < 10000)
		{
			$g->planet = 8;
		}
		elseif($g->win >= 10000)
		{
			$g->planet = 9;
		}
		$g->user = User::where('id', $g->user_id)->first();
		$info = array("planet" => $g->planet, "amount" => $g->win, "link" => '/user/'.$g->user_id, "image" => $g->user->avatar);
		return json_encode($info);
	}
	public function terms()
	{
		return view('pages.terms');
	}
	public function policy()
	{
		return view('pages.policy');
	}
	public function help()
	{
		return view('pages.help');
	}
	public function profile()
	{
		if(Auth::guest())
		{
			return redirect('/');
		}
		else
		{
			$user = User::where('id', Auth::user()->id)->first();
			$drops = Game::where('status', 1)->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->limit(12)->get();
			foreach($drops as $g)
			{
				if($g->win < 10)
				{
					$g->planet = 1;
				}
				elseif($g->win >= 10 && $g->win < 20)
				{
					$g->planet = 2;
				}
				elseif($g->win >= 20 && $g->win < 50)
				{
					$g->planet = 3;
				}
				elseif($g->win >= 50 && $g->win < 100)
				{
					$g->planet = 4;
				}
				elseif($g->win >= 100 && $g->win < 200)
				{
					$g->planet = 5;
				}
				elseif($g->win >= 200 && $g->win < 500)
				{
					$g->planet = 6;
				}
				elseif($g->win >= 500 && $g->win < 1000)
				{
					$g->planet = 7;
				}
				elseif($g->win >= 1000 && $g->win < 10000)
				{
					$g->planet = 8;
				}
				elseif($g->win >= 10000)
				{
					$g->planet = 9;
				}
			}
			return view('pages.profile', compact('user', 'drops'));
		}
	}
	public function history(Request $r)
	{
		if(!isset($r->limit) || !isset($r->skip) || !isset($r->userId))
		{
			return json_encode(array("Error" => "Nenhum resultado encontrado"));
		}
		else
		{
			$history = Game::where('status', 1)->where('user_id', $r->userId)->skip($r->skip)->limit($r->limit)->get();
			foreach($history as $g)
			{
				if($g->win < 10)
				{
					$g->planet = 1;
				}
				elseif($g->win >= 10 && $g->win < 20)
				{
					$g->planet = 2;
				}
				elseif($g->win >= 20 && $g->win < 50)
				{
					$g->planet = 3;
				}
				elseif($g->win >= 50 && $g->win < 100)
				{
					$g->planet = 4;
				}
				elseif($g->win >= 100 && $g->win < 200)
				{
					$g->planet = 5;
				}
				elseif($g->win >= 200 && $g->win < 500)
				{
					$g->planet = 6;
				}
				elseif($g->win >= 500 && $g->win < 1000)
				{
					$g->planet = 7;
				}
				elseif($g->win >= 1000 && $g->win < 10000)
				{
					$g->planet = 8;
				}
				elseif($g->win >= 10000)
				{
					$g->planet = 9;
				}
			}
			$ans = array();
			foreach($history as $h)
			{
				$a = array("planet" => $h->planet, "amount" => $h->win);
				array_push($ans, $a);
			}
			return json_encode($ans);
		}
	}
	public function payment_create(Request $r)
	{
		if(!isset($r->provider) || !isset($r->currency) || !isset($r->amount))
		{
			return json_encode(array("Error" => "Nenhum resultado encontrado"));
		}
		else
		{
			$settings = Settings::where('id', 1)->first();
			if(Auth::guest())
			{
				return json_encode(array("Error" => "Você precisa estra logado para esta ação!"));
			}
			$amount = $r->amount;
			$type = $r->provider;
			if((int)$amount < 1){
				$amount = 1;
			}
			
			$sandbox = $settings->tefway_test == '1';
			$url = $sandbox ? 'https://sandbox.meutef.com.br:33443' : 'https://api.meutef.com.br:33443';
			$url .= "/apipix/payments";
			$systemUrl = url('/')."/payments/tefway/callback";

			$uuid = $this->generateUUID();

			$curl = curl_init();
			
			curl_setopt_array($curl, array(
				CURLOPT_URL => $url,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_SSL_VERIFYHOST => 0,
				CURLOPT_SSL_VERIFYPEER => 0,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS =>'{
					"externalIdentifier": "'.$uuid.'",
					"totalAmount": "'.$amount.'",
					"currency": "BRL",
					"paymentInfo": {
						"transactionType": "InstantPayment",
						"instantPayment": {
							"alias": "'.$settings->tefway_pix.'",
							"qrCodeImageGenerationSpecification": {
								"errorCorrectionLevel": "M",
								"imageWidth": 400,
								"generateImageRendering": true
							},
							"expiration": 86400
						}
					},
					"callbackAddress": "'.$systemUrl.'"
				}',
				CURLOPT_HTTPHEADER => array(
					'Content-Type: application/json',
					'Authorization: Bearer ' . $settings->tefway_token,
				),
			));
			
			$response = curl_exec($curl);
			if(curl_error($curl)) {
				$responseData = array(
					"error" => curl_error($curl)
				);
			} else {
				$response = json_decode($response, true)['data']['instantPayment'];
				$base64 = $response['generateImage']['imageContent'];
				$base64 = 'data:image/png;base64,' . $base64;

				$responseData = array(
					"image" => $base64,
					"code" => $response['textContent'],
					"user" => Auth::user()->id
				);

				DB::table('payments')->insertGetId([
					'amount' => (int)$amount,
					'user' => Auth::user()->id,
					'time' => time(),
					'status' => 0,
					'external_id' => $uuid
				]);
	
			}

			return json_encode($responseData);
		}
	}

	private function generateUUID()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
		);
    }

	public function payout_create(Request $r)
	{
		
		if(!isset($r->amount) || !isset($r->currency) || !isset($r->provider) || !isset($r->purse))
		{
			return json_encode(array("Error" => "Nenhum resultado encontrado"));
		}
		else
		{
			$settings = Settings::where('id', 1)->first();
			if(Auth::guest())
			{
				return response('{"gameAmount":["Você precisa estra logado para esta ação!"]}', 422);
			}
			if((int)$r->amount < (int)$settings->min_with)
			{
				return response('{"gameAmount":["Valor mínimo para saque é de R$ '.(int)$settings->min_with.' "]}', 422);
			}
			if(Auth::user()->money < (int)$r->amount)
			{
				return response('{"gameAmount":["Seu saldo é insuficiente para solicitar saque!"]}', 422);
			}
			if($r->purse == '')
			{
				return response('{"gameAmount":["Digite sua chave PIX!"]}', 422);
			}
			$count = DB::table('withdraw')->where('user_id', Auth::user()->id)->where('status', 0)->count();
			if($count > 0)
			{
				return response('{"gameAmount":["Aguarde o processamento da última solicitação!"]}', 422);
			}
			$user = User::where('id', Auth::user()->id)->first();
			$user->money = $user->money - $r->amount;
			$user->save();
			//DB::table('withdraw')->insertGetId(['user_id' => Auth::user()->id, 'system' => $r->currency, 'wallet' => $r->purse ,'amount' => $r->amount]);
			DB::table('withdraw')->insertGetId(['user_id' => Auth::user()->id, 'system' => $r->currency, 'wallet' => $r->purse ,'amount' => $r->amount]);
			return json_encode($r->amount);
		}
	}
	public function profile_finance()
	{
		if(Auth::guest())
		{
			return redirect('/');
		}
		$pays = DB::table('payments')->where('user', Auth::user()->id)->orderBy('id', 'desc')->get();
		return view('pages.finance', compact('pays'));
	}
	public function profile_withdraws()
	{
		if(Auth::guest())
		{
			return redirect('/');
		}
		$withdraws = DB::table('withdraw')->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
		return view('pages.withdraws', compact('withdraws'));
	}
	public function profile_partner()
	{
		if(Auth::guest())
		{
			return redirect('/');
		}
		$vvod = DB::table('promocodes')->where('code', Auth::user()->ref_code)->get();
		if(count($vvod) > 0)
		{
			foreach($vvod as $v)
			{
				$v->user = User::where('id', $v->user)->first();
			}
		}
		return view('pages.partner', compact('vvod'));
	}
	public function activate(Request $r)
	{
		if(!isset($r->promocode))
		{
			return response('{"gameAmount":["Insira o código promocional!"]}', 422);
		}
		if(Auth::guest())
		{
			return response('{"gameAmount":["Você precisa estra logado para esta ação!"]}', 422);
		}
		if(Auth::user()->ref_use != NULL)
		{
			return response('{"gameAmount":["Você já uso seu código promocional!"]}', 422);
		}
		if(Auth::user()->ref_code == $r->promocode)
		{
			return response('{"gameAmount":["Você não pode inserir seu código promocional!"]}', 422);
		}
		$referer = User::where('ref_code', $r->promocode)->first();
		if($referer == false)
		{
			return response('{"gameAmount":["Este código promocional não existe!"]}', 422);
		}
		else
		{
			$summ = Settings::where('id', 1)->first();
			$user = User::where('id', Auth::user()->id)->first();
			$user->ref_use = $r->promocode;
			$user->money = $user->money + (int)$summ->promo_sum;
			$user->save();
			DB::table('promocodes')->insertGetId(["code" => $r->promocode, "user" => Auth::user()->id]);
			return json_encode((int)$summ->promo_sum);
		}
	}
	public function user_page($id)
	{
		if(!Auth::guest() && Auth::user()->id == $id)
		{
			return redirect('/profile');
		}
		else
		{
			$user = User::where('id', $id)->first();
			$drops = Game::where('status', 1)->where('user_id', $id)->orderBy('id', 'desc')->limit(12)->get();
			foreach($drops as $g)
			{
				if($g->win < 10)
				{
					$g->planet = 1;
				}
				if($g->win >= 10 && $g->win < 20)
				{
					$g->planet = 2;
				}
				elseif($g->win >= 20 && $g->win < 50)
				{
					$g->planet = 3;
				}
				elseif($g->win >= 50 && $g->win < 100)
				{
					$g->planet = 4;
				}
				elseif($g->win >= 100 && $g->win < 200)
				{
					$g->planet = 5;
				}
				elseif($g->win >= 200 && $g->win < 500)
				{
					$g->planet = 6;
				}
				elseif($g->win >= 500 && $g->win < 1000)
				{
					$g->planet = 7;
				}
				elseif($g->win >= 1000 && $g->win < 10000)
				{
					$g->planet = 8;
				}
				elseif($g->win >= 10000)
				{
					$g->planet = 9;
				}
			}
			return view('pages.user', compact('user', 'drops'));
		}
	}

	public function settings()
	{
		if(Auth::guest()){
			return redirect('/profile');
		}else{
			$user = User::find(Auth::user()->id);
			return view('pages.settings_user', compact('user'));
		}
	}

	public function settingsStore(Request $request)
	{
		$data = $request->all();
        $validator = Validator::make($data, [
            'cpf' => 'required|unique:users',
            'pix' => 'required|unique:users',
        ]);

        if($validator->fails()) return redirect()->back()->withErrors($validator)->withInput();

        $data['cpf'] = preg_replace('/[^0-9]/', '', $request->cpf);   

        $user = User::find(Auth::user()->id);
        $user->cpf = $data['cpf'];
        $user->pix = $data['pix'];
        $user->save();

        return redirect('/profile/settings')->withSuccess('Atualizado com Sucesso!');

	}	

	function getIP() 
	{
		if(isset($_SERVER['HTTP_X_REAL_IP'])) return $_SERVER['HTTP_X_REAL_IP'];
		return $_SERVER['REMOTE_ADDR'];
	}
	public function get_payment(Request $r)
	{
		$settings = Settings::where('id', 1)->first();
		$sign = md5($settings->fk_id.':'.$r->AMOUNT.':'.$settings->fk_secret2.':'.$r->MERCHANT_ORDER_ID);
		if($sign != $r->SIGN){
		  return "Erro de Assinatura";
		}
		$payment = DB::table('payments')->where('id', $r->MERCHANT_ORDER_ID)->first();
		if(count($payment) == 0)
		{
			return 'Pagamento não encontrado';
		}
		else
		{
			if($payment->status != 0){
				return "[Erro] Status do pagamento - pago antes da solicitação";
			}
			else
			{
				if($payment->amount != $r->AMOUNT){
					return "[Erro] O valor do pagamento está incorreto!";
				}
				else
				{
					$user = User::where('id', $payment->user)->first();
					$user->money = $user->money + $payment->amount;
					$user->deposit = $user->deposit + $payment->amount;
					$user->save();

					//1 tas kas uzaicina
					$settings = Settings::where('id', 1)->first();
					$percent = $settings->promo_percent;
					$te = User::where('ref_code', $user->ref_use)->first();
					if(count($te) == null || count($te) == 0){

					}
					else
					{
						$bon = ($percent/100)*$payment->amount;
						$te->money =   $te->money + $bon;
						$te->save();
					}
					\DB::table('payments')
					->where('id', $payment->id)
					->update(['status' => 1]);
					return 'success';
				}
			}
		}
	}

	public function upload(Request $request) {

		if($request->has('file') && strpos($request->file, ';base64')){
			
			$base64 = $request->file;

			$extension = explode('/', $base64);
			$extension = explode(';', $extension[1]);
			$extension = '.'.$extension[0];

			$name = time().$extension;
			$name = '/storage/avatar/'.$name;

            $separatorFile = explode(',', $base64);
            $file = $separatorFile[1];
            $path = public_path().$name;

            $t = file_put_contents($path, base64_decode($file));
			// Storage::putFile($path.$name, base64_decode($file));

			\Log::error($t);

			$user = User::where('id', Auth::user()->id)->first();
			$user->avatar = $name;
			$user->save();

			return Auth::user()->id;
		}

		return 0;
	}

}
