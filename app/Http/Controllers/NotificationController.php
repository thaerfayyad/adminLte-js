<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class NotificationController extends Controller
{
    //
    public function markAsRead(Request $request ,$id)
    {
        $notification =  Auth::user()->notifications()->find($id);
        $notification->markAsRead();
        return   redirect()->back();
    }
     public function destroy(Request $request ,$id )
    {
        $deleted = Auth::user()->notifications()->find($id)->delete();
        return response()->json([
            'title' =>$deleted ? 'Deleted Successfully ' : 'Delete Failed',
            'icon' => $deleted ? 'success' : ' error'
        ],$deleted ? Response::HTTP_OK :Response::HTTP_BAD_REQUEST);
      }
}
