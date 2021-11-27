<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data = Subcategory::with('category')->get();
        return response()->view('cms.subcategories.index',['subcategories'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories  = Category::all();
        return response()->view('cms.subcategories.create',['categories'=>$categories]);
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
        $validate = Validator($request->all() ,[
            'name' =>'required|string|max:100',
            'description' => 'nullable|max:150',
            'status' =>'required|boolean'
        ]);
        if(! $validate->fails()) {
            $subcategory = new Subcategory();
            $subcategory->name = $request->input('name') ;
            $subcategory->description = $request->input('description') ;
            $subcategory->category_id = $request->input('category_id') ;
            $subcategory->status = $request->input('status') ;
            $isSave = $subcategory->save();
            return response()->json([
                'message' => $isSave ? 'Created successfully' : 'Create Failed'
            ], $isSave ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);

        }else {
            return response()->json([
                'message' =>$validate->getMessageBag()->first(),
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(Subcategory $subcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Subcategory $subcategory)
    {
        //
        $categories = Category::all();
        return response()->view('cms.subcategories.edit',['subcategory'=>$subcategory,'categories' =>$categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        //

        $validate = Validator($request->all() ,[
            'name' =>'required|string|max:100',
            'description' => 'nullable|max:150',
            'status' =>'required|boolean'
        ]);
        if(! $validate->fails()) {

            $subcategory->name = $request->input('name') ;
            $subcategory->description = $request->input('description') ;
            $subcategory->category_id = $request->input('category_id') ;
            $subcategory->status = $request->input('status') ;
            $isSave = $subcategory->save();
            return response()->json([
                'message' => $isSave ? 'Updated successfully' : 'Update Failed'
            ], $isSave ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);

        }else {
            return response()->json([
                'message' =>$validate->getMessageBag()->first(),
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcategory $subcategory)
    {
        $isDelete = $subcategory->delete();
        return response()->json([
            'icon'  => $isDelete ? 'success' : 'error',
            'title' => $isDelete ? 'Delete successfully' : 'Delete Failed'
        ], $isDelete ? Response::HTTP_OK :Response::HTTP_BAD_REQUEST );
    }
}
