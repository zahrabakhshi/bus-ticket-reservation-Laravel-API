<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class passportAuthController extends Controller
{
    public function login(Request $request)
    {
        try {

            $login_credentials = [
                'email' => $request->email,
                'password' => $request->password,
            ];

            //check user credentials and login
            if (auth()->attempt($login_credentials)) {

                //Generate and return user access token
                $user_login_token = auth()->user()->createToken('user_login_token')->accessToken;

                return response()->json([
                    'token' => $user_login_token,
                    'status' => Response::HTTP_OK,
                ]);
            } else {

                return response()->json([
                    'error' => 'UnAuthorised Access',
                    'status' => Response::HTTP_UNAUTHORIZED,
                ]);
            }
        } catch (Throwable $exception) {
            return response()->json([
                'message' => 'login fail',
                'error' => $exception->getMessage(),
                'code' => $exception->getCode(),
            ]);
        }

    }

    public function register(Request $request)//TODO: need to set error validation
    {
        try {

            //Request Field Validation
            $this->validate($request, [
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
            ]);

            //Create new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            //Create new user_role record
            $user->roles()->attach(Role::select('id')->where('name','user')->get());

            //Generate and return user access token
            $access_token_example = $user->createToken('user_register_token')->accessToken;

            return response()->json([
                'token' => $access_token_example,
                'status' =>  Response::HTTP_OK,
            ]);

        } catch (Throwable $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
                'error' => $exception->errors(),
                'code' => $exception->getCode(),
                'status' => $exception->status,
            ]);
        }

    }
}
