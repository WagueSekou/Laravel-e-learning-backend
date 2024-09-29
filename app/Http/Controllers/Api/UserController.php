<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function createUser(Request $request){
        try {
            //Validating
            $validateUser = Validator::make($request->all(),
            [
                'avatar' => 'required',
                'type' => 'required',
                'open_id' =>'required',
                'name' => 'required',
                'username' => 'required',
                'email' => 'required',
                'password' => 'required|min:4'
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validator error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

             //validated will contain all user field values which will be save in DB
            $validated = $validateUser->validated();

            // // checking if this validated values exist or not in the database
            $map = [
            //email, phone, google, facebook, etc
            $map['type'] = $validated['type'],
            $map['open_id'] = $validated['open_id'],
        ];

            //finding user
            $user = User::where($map)->first();

            // //finding if already a logged in or not
            if (empty($user)) {
                //ensuring this user have never been in our DB && enter him in DB
                $validated["token"] = md5(uniqid().rand(10000, 99999));//this token becomes user_id
                
                $validated['created_at'] = Carbon::now();//saving user first time loging in  
                
                $validated['password'] = Hash::make($validated['password']);//encripting my password

                $userID = User::insertGetId($validated);//returning row id after saving

                $userInfo = User::where('Id', '=', $userID)->first();//users all information

                $accessToken = $userInfo->createToken(uniqid())->plainTextToken;

                $userInfo->access_token = $accessToken;
                User::where('id','=', $userID)->update(['access_token'=>$accessToken]);
                return response()->json([
                    'status' => true,
                    'message' => 'User Created Successfully',
                    'data' => $userInfo//replacing token by data which is simply userinfo
                ], 200);
            
            }else {
                if (!Hash::check($validated['password'], $user->password)) {
                    return response()->json([
                        'status' => false,
                        'message' => 'invalide credential'
                    ], 401);
                }
            }

            //user priviously logged
            $accessToken = $user->createToken(uniqid())->plainTextToken;
            $user->access_token = $accessToken;
            // User::where('id', '=', $user->id)->update(['access_token'=>$accessToken]);
            return response()->json([
                'status' => true,
                'message' => 'User logged in Successfully',
                'token' => $userInfo
            ], 200);



            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ]);

            // return response()->json([
            //     'status' => true,
            //     'message' => 'User Created Successfully',
            //     'token' => $user->createToken("API TOKEN")->plainTextToken
            // ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login user
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request){
        try {
             //Validating
            $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validator error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & password does not match with our record.'
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User logged in successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500); 
        }
    }
}
