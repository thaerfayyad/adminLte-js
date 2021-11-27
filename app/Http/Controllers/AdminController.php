<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $data = Admin::where('id', '!=' ,auth('admin')->id)->get();
        $data = Admin::all();
        $role = Role::all();
        return response()->view('cms.admins.index',[
        'admins' => $data ,
        'role' => $role
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // $roles = Role::where('guard_name' , '=', 'admin')->get();
        $roles = Role::all();

        return response()->view('cms.admins.create',[
            'roles' =>$roles
        ]);
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
        $validate = Validator($request->all(),[
            'role_id' => 'required|integer|exists:roles,id',
            'name' => 'required|string|min:3|max:44',
            'email' => 'required|string|email|unique:admins,email',
        ]);
        if(! $validate->fails()) {
            $role = Role::findById($request->input('role_id'),'admin');
            $admin = new Admin();
            $admin->name = $request->input('name');
            $admin->email = $request->input('email');
            $admin->password = Hash::make(12345);
            $isSaved= $admin->save();
            if($isSaved) $admin->assignRole($role); //give the model role
            return response()->json([
                'message' =>$isSaved ? 'created successfully' :' create failed'
            ], $isSaved ? Response::HTTP_CREATED :Response::HTTP_BAD_REQUEST);
        }else {
            return response()->json([
                'message' => $validate->getMessageBag()->first()
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
        $roles = Role::where('guard_name', '=' , 'admin')->get();;
        $adminRole = $admin->roles()->first();
        return response()->view('cms.admins.edit' ,[
            'admin' => $admin ,
            'roles' =>$roles ,
            'adminRole' =>$adminRole ,

        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
        $validate = Validator($request->all(),[
            'role_id' => 'required|integer|exists:roles,id',
            'name' => 'required|string|min:3|max:44',
            'email' => 'required|string|email|unique:admins,email,'.$admin->id,
        ]);
        if(! $validate->fails()) {
            $role = Role::findById($request->input('role_id'),'admin');
            $admin->name = $request->input('name');
            $admin->email = $request->input('email');
            $isSaved= $admin->save();
            if($isSaved) $admin->syncRoles($role); //give the model role
            return response()->json([
                'message' =>$isSaved ? 'updated successfully' :' update failed'
            ], $isSaved ? Response::HTTP_CREATED :Response::HTTP_BAD_REQUEST);
        }else {
            return response()->json([
                'message' => $validate->getMessageBag()->first()
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
        $deleted = $admin->delete();
        return response()->json([
            'title' =>$deleted ? 'Deleted successfully' :'delete failed',
            'icon' =>$deleted ? 'success' :'error'
        ], $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);

    }
}
