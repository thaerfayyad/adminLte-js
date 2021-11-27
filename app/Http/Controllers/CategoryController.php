<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::all();
        return response()->view('cms.categories.index', ['categories' =>$data]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return response()->view('cms\categories\create');
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
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);
        if(!$validator->fails()) {
            $category =new Category();
            $category->name = $request->input('name');
            $category->descriptions = $request->input('description');
            $category->status = $request->input('status');
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
        return response()->view('cms\categories\edit',['category'=>$category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
        $validator = Validator($request->all(),[
            'name' => 'required|string|min:3|max:45',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
        ]);
        if(!$validator->fails()) {
            $category->name = $request->input('name');
            $category->descriptions = $request->input('description');
            $category->status = $request->input('status');
            $isUpdated = $category->save();
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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        $isDelete = $category->delete();
        return response()->json([
            'icon'  => $isDelete ? 'success' : 'error',
            'title' => $isDelete ? 'Delete successfully' : 'Delete Failed'
        ], $isDelete ? Response::HTTP_OK :Response::HTTP_BAD_REQUEST );
    }
}
