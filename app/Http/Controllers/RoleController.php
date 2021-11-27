<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Role::withCount('permissions')->get();;
        return response()->view('cms.spatie.roles.index',['roles' =>$data]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.spatie.roles.create');
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
        $validator = Validator($request->all(), [
            'name' =>'required|string|min:3|max:50',
            'guard' =>'required|string|in:admin',
        ]);

      
        if(! $validator->fails()) {
            $role = new Role();

            $role->name = $request->input('name');
            $role ->guard_name = $request->input('guard');
            $isSaved = $role->save();
            return response()->json([
                'message' =>$isSaved ? 'created successfully' :' create failed'
            ], $isSaved ? Response::HTTP_CREATED :Response::HTTP_BAD_REQUEST);
        }else {
            return response()->json([
                'message'=> $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Spatie\Permission\Models\Role;  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
        $permissions = Permission::where('guard_name',$role->guard_name)->get();
        $rolePermissions = $role->permissions;
        foreach ($permissions as $permission) {
            $permission->setAttribute('assigned',false);
            foreach ($rolePermissions as $rolePermission) {
                if ($rolePermission->id == $permission->id) {
                    $permission->setAttribute('assigned', true);
                }
            }
        }
        return response()->view('cms.spatie.roles.role-permission', [
            'role'=>$role ,
            'permissions'=>$permissions]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
        return response()->view('cms.spatie.roles.edit',['role'=>$role]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Spatie\Permission\Models\Role;App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Spatie\Permission\Models\Role; $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
        $isDelete = $role->delete();
           return response()->json([
               'icon'  => $isDelete ? 'success' : 'error',
               'title' => $isDelete ? 'Delete successfully' : 'Delete Failed'
           ], $isDelete ? Response::HTTP_OK :Response::HTTP_BAD_REQUEST );

    }
}
