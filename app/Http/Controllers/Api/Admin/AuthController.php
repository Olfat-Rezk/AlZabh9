<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponses;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponses;
    public function register(Request $request){
        $rules =[
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:admins',
            'password' => 'required|string|min:8',
        ];
        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }

        //create admin in database
        $admin = new Admin([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),

        ]);
        $admin->save();
        return $this->success('Successfully created user');


    }
    public function login(Request $request){
        $rules =[
            'phone' => 'required|string|max:255|exists:admins',
            'password' => 'required|string|min:8',
        ];
        $validator= Validator::make($request->all(),$rules);
        if($validator->fails()){
            return  response()->json($validator->errors()->toJson(),400);
        }
        // $credentials =$request->only('phone','password');
        // if(! Auth::attempt($credentials)){
        //     return $this->error(['error'],'Unauthorized',401);

        // }

        // $admin= Admin::where('phone',$request->phone)->first();
        // if(!$admin){
        //     return $this->error(['bad credential']);
        // }
        //$admin->validateForPassportPasswordGrant($request->password);

        $credentials = $request->only(['phone']);

        $token = Auth::guard('admin')->check($credentials);

        if (!$token)
            return $this->error('E001', 'بيانات الدخول غير صحيحة');

        $admin = Auth::guard('admin')->user();
        $token = $admin->createToken('passport_token')->accessToken;
        //return token
        return $this->returnData('admin', $admin);

       // $admin['token'] = $admin->createToken('passport_token')->accessToken;

        // $admin = $request->user();
        // $tokenResult = $admin->createToken('Personal Access Token');
        // $token= $tokenResult->token;
        // $token->save();





    }
    public function logout(Request $request){
        $request->admin()->token()->revoke();
        return $this->success('you are logged out');

    }


    public function getAuthinticatedUser(Request $request){
        return $this->data(['admin'=>auth()->user],200);

    }


}
