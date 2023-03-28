<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Traits\ApiResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponses;
    public function register(Request $request){
        $rules =[
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }

        //create user in database
        $user = new User([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),

        ]);
        $user->save();
        return $this->success('Successfully created user');


    }
    public function login(Request $request){
        $rules =[
            'phone' => 'required|string|max:255|exists:users',
            'password' => 'required|string|min:8',
        ];
        $validator= Validator::make($request->all(),$rules);
        if($validator->fails()){
            return  response()->json($validator->errors()->toJson(),400);
        }
        $credentials =$request->only('phone','password');
        // if(! Auth('user')::attempt($credentials)){
        //     return $this->error(['error'],'Unauthorized',401);

        // }
        $user = User::where('phone',$request->phone)->first();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->save();
         return $this->data([
            'access_token'=>$tokenResult->accessToken,
            'token_type'=>'Bearer'
         ],'you are logged in successfully');





    }
    public function logout(Request $request){
        $request->user()->token()->revoke();
        return $this->success('you are logged out');

    }


    public function getAuthinticatedUser(Request $request){
        return $this->data(['user'=>auth()->user],200);

    }

}
