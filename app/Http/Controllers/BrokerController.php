<?php

namespace App\Http\Controllers;

use App\Models\Broker;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class BrokerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Broker::withCount('permissions')->get();
        return response()->view('cms.brokers.index',['brokers' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms.brokers.create');
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
            'name' => 'required|string|min:3|max:44',
            'email' => 'required|string|email|unique:admins,email',
        ]);
        if(! $validate->fails()) {

            $broker = new Broker();
            $broker->name = $request->input('name');
            $broker->email = $request->input('email');
            $broker->password = Hash::make(12345);
            $isSaved= $broker->save();
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
     * @param  \App\Models\Broker  $broker
     * @return \Illuminate\Http\Response
     */
    public function show(Broker $broker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Broker  $broker
     * @return \Illuminate\Http\Response
     */
    public function edit(Broker $broker)
    {
        //
        return response()->view('cms.brokers.edit',['broker' =>$broker]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Broker  $broker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Broker $broker)
    {
        //
        $validate = Validator($request->all(),[
            'name' => 'required|string|min:3|max:44',
            'email' => 'required|string|email|unique:admins,email',
        ]);
        if(! $validate->fails()) {
            $broker->name = $request->input('name');
            $broker->email = $request->input('email');
            $broker->password = Hash::make(12345);
            $isSaved= $broker->save();
            return response()->json([
                'message' =>$isSaved ? 'updated successfully' :' update failed'
            ], $isSaved ? Response::HTTP_OK :Response::HTTP_BAD_REQUEST);
        }else {
            return response()->json([
                'message' => $validate->getMessageBag()->first()
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Broker  $broker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Broker $broker)
    {
        //
        $deleted = $broker->delete();
        return response()->json([
            'title' =>$deleted ? 'Deleted successfully' :'delete failed',
            'icon' =>$deleted ? 'success' :'error'
        ], $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);

    }
}
