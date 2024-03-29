<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\hash;
use App\Models\User;

class UserController extends Controller
{
    //

    public function register(Request $request){
        // return $request->name;
        try{

            $check_email = User::where("email",$request->email);

            if($check_email->count()){

            }else{
                
            }

            $user = new User([
                "name" => $request->name,
                "email" => $request->email,
                "password" => hash::make($request->password)
            ]);

            $user->save();
            
            $success = true;
            $message = "ບັນທຶກຂໍ້ມູນສຳເລັດ!";

        }catch(\Illuminate\Database\QueryException $ex){

            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            "success" => $success,
            "message" => $message
        ];

        return response()->json($response);
    }
}
