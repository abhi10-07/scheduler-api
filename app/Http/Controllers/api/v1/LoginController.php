<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;


class LoginController extends Controller
{
    /**
     * Handles Registration Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|between:5,255|confirmed',
            'password_confirmation' => 'required|between:5,255'
        ]);

        
        if($validator->fails()){
            $errors = [];
            foreach($validator->errors()->toArray() as $key=>$messages) {
                $errors[$key] = $messages[0];
            }
            return response()->json($errors, 400);
        }
        
     
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

 
        $token = $user->createToken('scheduler')->accessToken;

        $dataArray['code'] = 1;
        $dataArray['message'] = "success";
        $dataArray['token'] = "Bearer $token";
 
        return response()->json($dataArray, 200);
    }
 
    /**
     * Handles Login Request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
 
        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('scheduler')->accessToken;

            $dataArray['code'] = 1;
            $dataArray['message'] = "success";
            $dataArray['token'] = "Bearer $token";
            
            return response()->json($dataArray, 200);
        } else {

            $dataArray['code'] = 0;
            $dataArray['message'] = "failed";
            $dataArray['error'] = 'UnAuthorised';
            return response()->json($dataArray, 401);
        }
    }
 
    /**
     * Returns Authenticated User Details
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function details()
    {
        return response()->json(['user' => auth()->user()], 200);
    }
}
