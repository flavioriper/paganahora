<?php
namespace App\Http\Controllers;
use App\Email;
use Auth;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
class LoginController extends Controller
{
    public function vklogin(Request $r)
    {
        $client_id = '51544512';
        $client_secret = 'Xl1SvfFCNobh57aD9g1v';
        $redirect_uri = 'jogo-da-raspadinha.paineldemonstrativo.com.br';

        if (!is_null($r->code)) {
			$obj = json_decode($this->curl('https://oauth.vk.com/access_token?client_id=' . $client_id . '&client_secret=' . $client_secret . '&redirect_uri=http://' . $redirect_uri . '/login&code=' . $r->code));
            if (isset($obj->access_token)) {
                $info = json_decode($this->curl('https://api.vk.com/method/users.get?user_ids&fields=photo_200&access_token=' . $obj->access_token . '&v=V'), true);
				$user = User::where('login2', $info['response'][0]['uid'])->first();
                if($user == NULL) {
                  if(array_key_exists('photo_200', $info['response'][0])){
                      $photo = $info['response'][0]['photo_200'];
                  }else{
                    $photo = 'http://vk.com/images/camera_200.png';
                  }
                    $user = User::create([
                        'username' => $info['response'][0]['last_name'] . ' ' . $info['response'][0]['first_name'],
                        'avatar' => $photo,
                        'login' => 'id'.$info['response'][0]['uid'],
                        'login2' => $info['response'][0]['uid'],
                        'ref_code' => $this->generate(),
                        'nick' => $this->generate_name()
                    ]);
                } else {
                  if(array_key_exists('photo_200', $info['response'][0])){
                      $photo = $info['response'][0]['photo_200'];
                  }else{
                    $photo = 'http://vk.com/images/camera_200.png';
                  }
                    $user->username = $info['response'][0]['first_name'] . ' ' . $info['response'][0]['last_name'];
                    $user->avatar = $photo;
                    $user->login = 'id'.$info['response'][0]['uid'];
                    $user->login2 = $info['response'][0]['uid'];
                    $user->save();
                }
                Auth::login($user, true);
                return redirect('/');
            }
        } else {
			sleep(3);
            return redirect('https://oauth.vk.com/authorize?client_id=' . $client_id . '&display=page&redirect_uri=http://' . $redirect_uri . '/login&scope=friends,photos,status,offline,&response_type=code&v=5.53');
        }
    }
    public function register(Request $r)
    {
        $userUnique = User::where('login', $r->username)->count();
        if($userUnique > 0) {
            return array(
                "statusCode" => "400",
                "message" => "Usuário já existe"
            );
        }

        $userUnique = User::where('email', $r->email)->count();
        if($userUnique > 0) {
            return array(
                "statusCode" => "400",
                "message" => "Email já existe"
            );
        }

        /*$cpf = preg_replace('/[^0-9]/', '', $r->cpf);
        $userUnique = User::where('cpf', $cpf)->count();
        if($userUnique > 0) {
            return array(
                "statusCode" => "400",
                "message" => "CPF já existe"
            );
        }

        $userUnique = User::where('pix', $r->pix)->count();
        if($userUnique > 0) {
            return array(
                "statusCode" => "400",
                "message" => "PIX já existe"
            );
        }*/

        $user = User::create([
            'username' => $r->name,
            'avatar' => 'storage/avatar/apostador.png',
            'login' => $r->username,
            'email' => $r->email,
            //'cpf' => $cpf,
            //'pix' => $r->pix,
            'login2' => '',
            'ref_code' => $this->generate(),
            'nick' => $this->generate_name(),
            'password' => Hash::make($r->password)
        ]);
        Auth::login($user, true);
        return array("statusCode" => "200");
    }

    public function login(Request $r)
    {
        $user = User::where('login', $r->username)->orWhere('email',$r->username)
            ->first();
        if(isset($user) && Hash::check($r->password, $user->password)) {
            Auth::login($user, true);
            return array("statusCode" => "200");
        } else {
            return array(
                "statusCode" => "400",
                "message" => "Usuário e/ou senha incorretos"
            );
        }
    }

    public function password_recovery(Request $r)
    {
        $user = User::where('email', $r->email)
            ->first();
        if(isset($user)) {
            $user->hash = $this->generateUUID();
            $user->save();

            $url = url('/') . "?recovery=1&hash=".$user->hash;
            try {
                Email::sendEmail($user->email, 'Recuperação de senha', view('pages.recovery')->with('url', $url)->render());
                return array("statusCode" => "200");
            }catch (\Exception  $e){
                return array(
                    "statusCode" => "400",
                    "message" => $e->getMessage(),
                );
            }
            
        } else {
            return array(
                "statusCode" => "400",
                "message" => "Email não existe"
            );
        }
    }

    public function password_recovery_update(Request $r)
    {
        $user = User::where('hash', $r->hash)
            ->first();
        if(isset($user)) {
            $user->password = Hash::make($r->password);
            $user->hash = "";
            $user->save();
            Auth::login($user, true);
            return array("statusCode" => "200");
        } else {
            return array(
                "statusCode" => "400",
                "message" => "Ocorreu um problema ao recuperar senha"
            );
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


    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
    public function curl($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
    public function generate_name()
    {
        $length = 8;
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }
    public function generate()
    {
        $length = 5;
        $chars = 'abcdefghijkmnoprstxyzABСDEFGHIJKMNOPQRSTXYZ123456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
		return $string;
    }
}