<?php

namespace App\Http\Controllers;

use Dotenv\Validator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RolePermissionController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Spatie\Permission\Models\Role $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Role $role)
    {
        //
        $validator =Validator([$request->all(),
            'permission_id' => 'required|integer|exists:permissions,id',
        ]);
        if (! $validator->fails()) {
            // $permission = Permission::findById($request->input('permission_id'), $role->guard_name);
            $permission = Permission::findOrFail($request->input('permission_id'));
            $message = '';
            if ($role->hasPermissionTo($permission)) {
                $role->revokePermissionTo($permission);
                $message = 'Permission revoked successfully';
            } else {
                $role->givePermissionTo($permission);
                $message = 'Permission assigned successfully';
            }
            return response()->json(['message'=>$message,Response::HTTP_OK]);
        } else {
                return response()->json([
                    'message'=> $validator->getMessageBag()->first()
                ], Response::HTTP_BAD_REQUEST);
        }

    }

}
