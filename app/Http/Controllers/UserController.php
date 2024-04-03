<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use JWTAuth;

class UserController extends Controller
{
    //

    public function __construct(){
        $this->middleware("auth:api", ["except" => ["login", "register"]]);
    }

    public function register(Request $request){
        // return $request->name;
        try{

            $check_email = User::where("email",$request->email);

            // return $check_email->count();

            if($check_email->count()){
                $success = false;
                $message = "ອີເມວລ໌ນິ້: ".$request->email." ໄດ້ເຄີຍລົງທະບຽນແລ້ວ!";
            } else {

                
            $user = new User([
                "name" => $request->name,
                "email" => $request->email,
                "password" => hash::make($request->password)
            ]);

            $user->save();

            $success = true;
            $message = "ບັນທຶກຂໍ້ມູນສຳເລັດ!";

            }


        } catch (\Illuminate\Database\QueryException $ex){

            $success = false;
            $message = $ex->getMessage();

        }

        $response = [
            "success" => $success,
            "message" => $message
        ];

        return response()->json($response);
    }

    public function login(Request $request){

        $user_login = [
            "email"=>$request->email,
            "password"=>$request->password
        ];

        $token = JWTAUTH::attempt($user_login);
        $user = Auth::user();

        if(!$token){
            return response()->json([
                "success" => false,
                "message" => "ອີເມວລ໌ ຫຼືລະຫັດຜ່ານ ບໍ່ຖຶກຕ້ອງ!"
            ]);
        } else {
            return response()->json([
                "success" => true,
                "message" => "ສຳເລັດ!",
                "user" => $user,
                "token" => $token
            ]);
        }

    }

    public function logout(){
        $token = Auth::getToken();
        $invalidate = Auth::invalidate($token);
        if($invalidate){
            return response()->json([
                "success" => true,
                "message" => "ສຳເລັດ!",
            ]);
        }
    }
}
