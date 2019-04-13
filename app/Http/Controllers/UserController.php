<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Helpers\JwtAuth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class UserController extends Controller{

    public function __construct(){
        $this->middleware('Authorization',["only"=>['index','update','destroy']]);
    }

    public function index(){
        $users=User::all();
        return response()->json(['users'=>$users],200);
    }

    public function store(Request $request){

        $json=$request->input('json',null);
        $params=json_decode($json);
        $params_array=json_decode($json,true);


        $validate=\Validator::make($params_array,[
            'name'=>'required',
            'surname'=>'required',
            'email'=>'required|email|unique:users',
            'nick'=>'required|min:5|unique:users|min:5|max:10',
            'password'=>'required|min:6'
        ]);

        if($validate->fails()){
            return response()->json($validate->errors(),400);
        }

        $user=new User();
        $user->name=$params->name;
        $user->surname=$params->surname;
        $user->email=$params->email;
        $user->nick=$params->nick;
        //Encriptando password
        $passwordHash=Hash::make($params->password);
        $user->password=$passwordHash;
        $user->save();

        $data=array([
            'status'=>'success',
            'message'=>'Usuario  creado correctactamente'
        ]);
        return response()->json($data,201);
    }

    public function show($id){
        $user=User::find($id);
        if(is_object($user)){
            return response()->json(['user'=>$user],200);
        }else{
            return response()->json(['status'=>'error','message'=>'Usuario no encontrado'],404);
        }
    }

    public function upload(Request $request, $id){
        $user=User::find($id);
        if(is_object($user)) {

            $image_path = $request->file('file');

             $validate=\Validator::make(['image'=>$image_path],[
                'image'=>'required|image',
             ]);


            if($validate->fails()){
                return response()->json([$validate->errors(),$image_path],400);
            }


                $image_path_name=time().$image_path->getClientOriginalName();
                Storage::disk('user')->put($image_path_name,File::get($image_path));

                $user->image=$image_path_name;
                $user->update();

                return response()->json(['status'=>'success','message'=>'Imagen subida con éxito'],201);
        }else{
            return response()->json(['status'=>'error','message'=>'Usuario no encontrado'],404);
        }
    }


    public function update(Request $request, $id){
        $user=User::find($id);
        if(is_object($user)){
            $json=$request->input('json',null);
            $params=json_decode($json);
            $params_array=json_decode($json,true);


            $validate=\Validator::make($params_array,[
                'name'=>'required|string',
                'surname'=>'required|string',
                'email'=>'required|email|unique:users,nick,'.$id,
                'nick'=>'required|string|min:5|max:10|unique:users,nick,'.$id,
                'password'=>'required|min:6'
            ]);


            if($validate->fails()){
                return response()->json($validate->errors(),400);
            }

            $user->name=$params->name;
            $user->surname=$params->surname;
            $user->email=$params->email;
            $user->nick=$params->nick;
            //Encriptando password
            $passwordHash=Hash::make($params->password);
            $user->password=$passwordHash;

            $image_path=$request->file('image_path');

            if($image_path){
                $image_path_name=time().$image_path->getClientOriginalName();

                Storage::disk('user')->put($image_path_name,File::get($image_path));

                $user->image=$image_path_name;
            }

            $user->update();

            return response()->json(['status'=>"success","message"=>"Usuario actualizado con éxito"],200);
        }else{
            return response()->json(['status'=>'error','message'=>'Usuario no encontrado'],404);
        }
    }


    public function destroy($id){
        $user=User::find($id);
        if(is_object($user)){
            $user->delete();
            return response()->json(['status'=>"success","message"=>"Usuario eliminado con éxito"],200);
        } else{
            return response()->json(['status'=>'error','message'=>'Usuario no encontrado'],404);
        }
    }

    public function login(Request $request){
        /*El username es tratado como el nick o correo del usuario*/
       $jwt=new JwtAuth();

        $json=$request->input('json',null);
        $params=json_decode($json);
        $params_array=json_decode($json,true);

        $validation=\Validator::make($params_array,[
            'username'=>'required|min:5',
            'password'=>'required|min:6'
        ]);

        if($validation->fails()){
            return response()->json($validation->errors(),400);
        }
        $getToken=(isset($params->getToken))?$params->getToken:false;

        $signup=$jwt->signup($params->username, $params->password,$getToken);

        return response()->json($signup,200);
    }


    public function download($filename){
        $file=Storage::disk('user')->get($filename);
        return new Response($file,200);
    }
}

