<?php
namespace App\Helpers;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Hash;

class JwtAuth{
    private $key;

    public function __construct(){
        $this->key="ESTA-ES-MI-clave-19021o2kn323/(%$";
    }


    public function signup($username,$password,$getToken=false){
        $signup=false;

        $user=User::where(['nick'=>$username])->orWhere(['email'=>$username])->first();

        if(is_object($user)){
            if(Hash::check($password,$user->password)){

                $token = array(
                    'sub' => $user->id,
                    'email' =>$user->email,
                    'username'=>$user->username,
                    'name'=>$user->name,
                    'surname'=>$user->surname,
                    'iat'=>time(),
                    'exp'=>time()+(7*24*60*60)
                );

                //codificando
                $jwt=JWT::encode($token,$this->key,'HS256');

                //Decodificando mi token
                $decode=JWT::decode($jwt,$this->key,['HS256']);

                if(!$getToken){
                    return $jwt;
                }else{
                    return $decode;
                }
            }else{
                return array('status' => 'error', 'message' => 'Error de credenciales');
            }

        }else{
            return array('status' => 'error', 'message' => 'Error de credenciales');
        }


    }


    public function checkToken($jwt,$getIdentity=false){
        $auth=false;
        try{
            $decode=JWT::decode($jwt,$this->key,['HS256']);
        }catch (\UnexpectedValueException $e){
            $auth=false;
        }catch (\DomainException $e){
            $auth=false;
        }

        if(isset($decode)&&is_object($decode)&&isset($decode->sub)){
            $auth=true;
        }

        if($getIdentity){
            return $decode;
        }

        return $auth;
    }


}
