<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $data = City::all();
        if($request->expectsJson()) {
            return response()->json(['status',true, 'data'=>$data]);
        }   else {
            return response()->view('cms.city.index',[
                'cities' =>$data,
            ]);

        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->view('cms.city.create');
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
            'address' => 'nullable|string|min:3|max:45',
        ]);
        if(!$validator->fails()) {
            $category =new City();
            $category->name = $request->input('name');
            $category->address = $request->input('address');

            $isSave = $category->save();

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
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        //
        return response()->view('cms.city.edit',[
            'city' =>$city,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        //
        $validator = Validator($request->all(),[
            'name' => 'required|string|min:3|max:45',
            'address' => 'nullable|string|min:3|max:45',
        ]);
        if(!$validator->fails()) {
            $city->name = $request->input('name');
            $city->address = $request->input('address');

            $isUpdated = $city->save();
            return response()->json([
                'message' => $isUpdated ? 'Updated successfully' : 'update Failed'
            ], $isUpdated ? Response::HTTP_OK: Response::HTTP_BAD_REQUEST);

        }else {
            return response()->json(['message' => $validator->getMessageBag()->first()
        ], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {

           $isDelete = $city->delete();
           return response()->json([
               'icon'  => $isDelete ? 'success' : 'error',
               'title' => $isDelete ? 'Delete successfully' : 'Delete Failed'
           ], $isDelete ? Response::HTTP_OK :Response::HTTP_BAD_REQUEST );
    }
}
