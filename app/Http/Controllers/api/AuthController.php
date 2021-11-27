<?php

namespace App\Http\Controllers\api;

use App\Helpers\Messages;
use App\Http\Controllers\Controller;
use App\Models\Broker;
use App\Models\User;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
//    public function login(Request $request)
//     {
//         $validator = Validator($request->all(), [
//             'email' => 'required|email|exists:users,email',
//             'password' => 'required|string|min:3',
//         ]);

//         if (!$validator->fails()) {
//             $user = User::where('email', '=', $request->input('email'))->first();
//             if (Hash::check($request->input('password'), $user->password)) {
//                 $token = $user->createToken('user-api');
//                 $user->setAttribute('token', $token->accessToken);
//                 return response()->json([
//                     'status' => true,
//                     'message' => Messages::getMessage('LOGGED_IN_SUCCESSFULLY'),
//                     'object' => $user
//                 ]);
//             } else {
//                 //ERROR_CREDENTIALS
//                 return response()->json([
//                     'message' => Messages::getMessage('ERROR_CREDENTIALS')
//                 ], Response::HTTP_BAD_REQUEST);
//             }
//         } else {
//             return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
//         }
//     }

    // public function login(Request $request) // login in one device only
    // {
    //     $validator = Validator($request->all(), [
    //         'email' => 'required|email|exists:users,email',
    //         'password' => 'required|string|min:3',
    //     ]);

    //     if (!$validator->fails()) {
    //         $user = User::where('email', '=', $request->input('email'))->first();
    //         if (Hash::check($request->input('password'), $user->password)) {
    //             if(! $this->checkActiveSessions($user->id)){
    //                 $token = $user->createToken('User-API');
    //                 $user->setAttribute('token', $token->accessToken);
    //                 return response()->json([
    //                     'status' => true,
    //                     'message' => Messages::getMessage('LOGGED_IN_SUCCESSFULLY'),
    //                     'object' => $user
    //                 ]);
    //             }

    //             else{
    //                 return response()->json([
    //                     'message' => Messages::getMessage('MULTI_ACCESS_ERROR')
    //                 ], Response::HTTP_FORBIDDEN);

    //             }

    //         } else {
    //             //ERROR_CREDENTIALS
    //             return response()->json([
    //                 'message' => Messages::getMessage('ERROR_CREDENTIALS')
    //             ], Response::HTTP_BAD_REQUEST);
    //         }
    //     } else {
    //         return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
    //     }
    // }

    // public function login(Request $request) // end session when login to login in other device
    // {
    //     $validator = Validator($request->all(), [
    //         'email' => 'required|email|exists:users,email',
    //         'password' => 'required|string|min:3',
    //     ]);

    //     if (!$validator->fails()) {
    //         $user = User::where('email', '=', $request->input('email'))->first();
    //         if (Hash::check($request->input('password'), $user->password)) {
    //                 $this->endPreviousSessions($user->id);
    //                 $token = $user->createToken('User-API');
    //                 $user->setAttribute('token', $token->accessToken);
    //                 return response()->json([
    //                     'status' => true,
    //                     'message' => Messages::getMessage('LOGGED_IN_SUCCESSFULLY'),
    //                     'object' => $user
    //                 ]);

    //         } else {
    //             //ERROR_CREDENTIALS
    //             return response()->json([
    //                 'message' => Messages::getMessage('ERROR_CREDENTIALS')
    //             ], Response::HTTP_BAD_REQUEST);
    //         }
    //     } else {
    //         return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
    //     }
    // }

    public function login(Request $request) // login with broker grant  Broker-PGCT ->" passport grant client token"

    {
        $validator = Validator($request->all(), [
        'email' => 'required|email',
        'password' => 'required|string|min:3',
    ]);

    if (!$validator->fails()) {
        try {
            $response = Http::asForm()->post('http://127.0.0.1:8001/oauth/token', [  //if project live us url
                'grant_type' =>'password',  // from oauth_client table
                'client_id' =>'3',
                'client_secret' =>'qy5c1NQWtdDhlroneZmvmdwthrMl0ist27KZM9hr',
                'username'=> $request->input('email'),
                'password' =>$request->input('password'),
                'scope' => '*' // permissions
               ]);
            //    return $response;
               $user = Broker::where('email',$request->input('email'))->first();
               $user->setAttribute('token' ,$response->json()['access_token']);
               $user->setAttribute('token_type',$response->json()['token_type']);
               return response()->json([
                   'status' =>true,
                   'message' => Messages::getMessage('LOGGED_IN_SUCCESSFULLY'),
                   'object' =>$user
               ]);
        } catch (\Throwable $th) {
            return response()->json($response->json(),Response::HTTP_UNAUTHORIZED);
        }
    } else {
        return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
    }

    }
    public function userLogin(Request $request)

    {
        $validator = Validator($request->all(), [
        'mobile' => 'required|numeric|digits:8',
        'password' => 'required|string|min:3',
    ]);

    if (!$validator->fails()) {
        try {
            $response = Http::asForm()->post('http://127.0.0.1:8001/oauth/token', [  //if project live us url
                'grant_type' =>'password',  // from oauth_client table
                'client_id' =>'2',
                'client_secret' =>'nUibsSAgVhgtwlquM75qw8fLNZhfOrDEzFjfpykN',
                'username'=> $request->input('mobile'),
                'password' =>$request->input('password'),
                'scope' => '*' // permissions
               ]);
            //    return $response;
               $user = User::where('mobile',$request->input('mobile'))->first();
               $user->setAttribute('token' ,$response->json()['access_token']);
               $user->setAttribute('token_type',$response->json()['token_type']);
               return response()->json([
                   'status' =>true,
                   'message' => Messages::getMessage('LOGGED_IN_SUCCESSFULLY'),
                   'object' =>$user
               ]);
        } catch (\Throwable $th) {
            return response()->json($response->json(),Response::HTTP_UNAUTHORIZED);
        }
    } else {
        return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
    }

    }


    public function register(Request $request)
    {
        $validator = Validator($request->all(), [
            'name' => 'required|string|min:3|max:45',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'required|numeric|unique:users,mobile|digits:8',
            'password' => 'required|string|min:3',
        ]);

        if (!$validator->fails()) {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->mobile = $request->input('mobile');
            $user->password = Hash::make($request->input('password'));
            $isSaved = $user->save();
            return response()->json([
                'message' => Messages::getMessage($isSaved ? 'REGISTERED_SUCCESSFULLY' : 'REGISTRATION_FAILED'),
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function forgetPassword(Request $request)
    {
        $validator  = Validator($request->all(), [
            'email' =>'required|email|exists:users,email',
        ]);
        if(!$validator->fails()) {
            $user = User::where('email',$request->input('email'))->first();
            $authCode = random_int(1000,9999); // 4  digit code
            $user->auth_code = Hash::make($authCode);
            $isSaved = $user->save();
            return response()->json(
                [
                'status' =>$isSaved,
                'message' => $isSaved ? 'Reset code sent successfully' :' Failed to send reset code !',
                'code'   => $authCode,// just for test
            ], $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );


        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }


    public function resetPassword(Request $request)
    {
        $validator = Validator($request->all(), [
            'email' => 'required|email|exists:users,email',
            'auth_code' => 'required|numeric|digits:4',
            'password' => 'required|string|min:3|max:15|confirmed'
        ]);

        if (!$validator->fails()) {
            $user = User::where('email', '=', $request->input('email'))->first();
            if (!is_null($user->auth_code)) {
                if (Hash::check($request->input('auth_code'), $user->auth_code)) {
                    $user->password = Hash::make($request->input('password'));
                    $user->auth_code = null;
                    $isSaved = $user->save();
                    return response()->json(
                        [
                            'status' => $isSaved,
                            'message' => Messages::getMessage($isSaved ? 'RESET_PASSWORD_SUCCESS' : 'RESET_PASSWORD_FAILED'),
                        ],
                        $isSaved ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
                    );
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => Messages::getMessage('AUTH_CODE_ERROR')
                    ], Response::HTTP_BAD_REQUEST);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => Messages::getMessage('NO_PASSWORD_RESET_CODE')
                ], Response::HTTP_BAD_REQUEST);
            }
        } else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    private function checkActiveSessions($userID) // login in one  only device
    {
        return DB::table('oauth_access_tokens')
        ->where('user_id', '=', $userID)
        ->where('revoked', '=', false)
        ->exists();
    }
    private function endPreviousSessions($userID) // end session in logging device and login im another device
    {
        return DB::table('oauth_access_tokens')
        ->where('user_id', '=', $userID)
        ->where('name','=','User-API')
        ->update([
            'revoked' =>true
        ]);
    }

    public function logout(Request $request)
    {
        $token = $request->user('user-api')->token();
        $revoked = $token->revoke();
        return response()->json([
            'status' => $revoked,
            'message' => Messages::getMessage($revoked ? 'LOGGED_OUT_SUCCESSFULLY' : 'LOGGED_OUT_FAILED'),
        ]);
    }



}
