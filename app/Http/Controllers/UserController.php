<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = User::withCount('permissions')->get();
        return response()->view('cms.users.index',['users'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator($request->all(),[
            'name' => 'required|string|min:3|max:45',
            'email' => 'required|email|string|unique:users,email',
            'mobile'=>'required|numeric|digits:8|unique:users,mobile'
        ]);
        if(!$validator->fails()) {
            $user =new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->mobile = $request->input('mobile');
            $user->password = Hash::make('12345');

            $isSave = $user->save();

            return response()->json([
                'message' => $isSave ? 'Created successfully' : 'Create Failed'
            ], $isSave ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);

        } else {
            return response()->json([
                'message' =>   $validator->getMessageBag()->first()
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        $isDelete = $user->delete();
        return response()->json([
            'icon'  => $isDelete ? 'success' : 'error',
            'title' => $isDelete ? 'Delete successfully' : 'Delete Failed'
        ], $isDelete ? Response::HTTP_OK :Response::HTTP_BAD_REQUEST );
    }
}
