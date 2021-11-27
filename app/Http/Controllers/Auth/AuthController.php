<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\MessageBag;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
    //
    public function showLogin()
     {
        return response()->view('cms\auth\login');
    }
    public function login(Request $request)
    {
        $validator = Validator($request->all(), [
               'email'       => 'required|email',
               'password'    => 'required|string|min:3|max:30',
               'remember_me' => 'required|boolean'
        ]);

        if(! $validator->fails())
        {
                $credentials = ['email' => $request->input('email'), 'password'=> $request->input('password') ];
                if(Auth::guard('admin')->attempt($credentials,$request->input('remember_me'))){
                    return response()->json([
                        'message' => 'Logged Successfully'
                    ], Response::HTTP_OK);
                }else {
                    return response()->json([
                        'message' =>  $validator->getMessageBag()->first()
                    ], Response::HTTP_BAD_REQUEST);
                }

        }else {
            return response()->json([
                'message' =>  $validator ->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }

    }
    public function editPassword(Request $request)
    {
        return response()->view('cms\auth\edit-password');
    }
    public function updatePassword(Request $request)
    {
        $validator = Validator($request->all(),[
            'password'=>'required|string|current_password:admin',
            'new_password'=>'required|string|min:2|max:30|confirmed',
            'new_password_confirmation'=>'required|string|min:2|max:30',
        ]);
        if(! $validator ->fails()) {
            $user = auth('admin')->user();
            $user->password = Hash::make($request->input('password'));
            $isSave =  $user->save();
            return response() ->json([
                'message' => $isSave ? 'password updated successfully' :' update failed'
            ],$isSave ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);



        }else {
            return response()->json([
                'message' => $validator->getMessageBag()->first()
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout(Request $request)
    {
        //auth('admin')->logout();
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        return redirect()->route('auth.login-show');

    }
}
