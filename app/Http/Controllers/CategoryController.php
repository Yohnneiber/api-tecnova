<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
class CategoryController extends Controller{

    public function __construct(){
        $this->middleware('Authorization');
    }

    public function index(){
        $categories=Category::all();
        return response()->json(["categories"=>$categories],200);
    }


    public function store(Request $request){
        $json=$request->input('json',null);
        $params=json_decode($json);
        $params_array=json_decode($json,true );

        $validate=\Validator::make($params_array,[
            'name'=>'required|min:4'
        ]);

        if($validate->fails()){
            return response()->json($validate->errors(),400);
        }
        $category=new Category();
        $category->category=$params->name;
        $category->save();

        $data=array([
            'status'=>'success',
            'message'=>'Categoria creada correctamente'
        ]);

        return response()->json($data,201);
    }

    public function show($id){




    }

    public function update(Request $request, $id){

    }

    public function destroy($id){

    }
}
