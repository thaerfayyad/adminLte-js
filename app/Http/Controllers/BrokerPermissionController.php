<?php

namespace App\Http\Controllers;

use App\Models\Broker;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class BrokerPermissionController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $broker = Broker::findOrFail($id);
        $brokerPermissions = $broker->permissions;
        $permissions = Permission::where('guard_name','=','broker')->get();

        foreach ($permissions as $permission) {
            $permission->setAttribute('assigned',false);
            foreach($brokerPermissions as $brokerPermission) {
                if ($brokerPermission->id == $permission->id){
                    $permission->setAttribute('assigned',true);
                }
            }
        }
        return response()->view('cms.brokers.broker-permission',[
            'broker' =>$broker,
            'permissions' =>$permissions
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validator = Validator($request->all(), [
            'permission_id' => 'required|integer|exists:permissions,id',
        ]);

        if (! $validator->fails()){

            $permission = Permission::findById($request->input('permission_id'),'broker');
            $broker =Broker::findOrFail($id);
            if($broker->hasPermissionTo($permission)){
                $message = ' ';
            $broker->revokePermissionTo($permission);
            $message = 'Permissions revoke successfully ';
            }else {
                $broker->givePermissionTo($permission);
                $message = 'Permissions assigned successfully ';
            }
            return response()->json([
                'message'=> $message
            ], Response::HTTP_OK);
        }else {
            return response()->json([
                'message'=> $validator->getMessageBag()->first()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
