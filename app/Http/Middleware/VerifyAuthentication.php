<?php

namespace App\Http\Middleware;

use Closure;
use App\Helpers\JwtAuth;
class VerifyAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $hash=$request->header('Authorization',null);

        $Jwt= new JwtAuth();
        $checkToken=$Jwt->checkToken($hash);
        if($checkToken){
            return $next($request);
        }else{
            return response()->json(['status'=>'error','message'=>'No autorizado.'],401);
        }
    }
}
