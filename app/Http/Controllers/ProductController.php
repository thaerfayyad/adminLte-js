<?php

namespace App\Http\Controllers;

use App\Jobs\AdminNotificationJob;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Notifications\NewProductNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
       $data = Product::with(['subcategory'=>function($query) {
            $query->with('category');
            }])->paginate(20);
        // $data = Product::with('subcategory')->with('category')->paginate(20); // N+1
        // return dd($data);
        return response()->view('cms.products.index',['products'=>$data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return response()->view('cms.products.create',[
            'categories' =>$categories,
            'subcategories' => $subcategories,
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
        $validator = Validator($request->all(),[

            'name' => 'required|string|min:3|max:45',
            'description' => 'nullable|string',
            'img' => 'required',
            // 'status' => 'required|boolean',
            // 'status' => 'required|boolean',
        ]);
        if(!$validator->fails()) {
            $product = new Product();
            $product->name = $request->input('name');
            // $product->status = $request->input('status');
            $product->subcategory_id = $request->input('subcategory_id');
            $product->description = $request->input('description');

            if ($request->hasFile('img')) {
                $image = $request->file('img');
                $imageName = Carbon::now()->format('Y_m_d_h_i') . '_' . $product->name . '.' . $image->getClientOriginalExtension();
                $request->file('img')->storeAs('/products', $imageName, ['disk' => 'public']);
                $product->img = 'products/' . $imageName;
            }
            $isSaved = $product->save();
            if($isSaved){
                foreach(Admin::all() as $admin)
                {
                    // AdminNotificationJob::dispatch(); // running queue
                    dispatch(new AdminNotificationJob($product->name, $admin)); //other method
                // Auth::user()->notify((new NewProductNotification($product->name)));
                }

            }

            return response()->json([
                'message' => $isSaved ? 'Created successfully' : 'Create Failed'
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);

        } else {
            return response()->json([
                'message' =>   $validator->getMessageBag()->first()
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return response()->view('cms.products.edit',[
            'product' =>$product,
            'categories' =>$categories,
            'subcategories' => $subcategories,
    ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator($request->all(),[

            'name' => 'required|string|min:3|max:45',
            'description' => 'nullable|string',
            'img' => 'required',
            // 'status' => 'required|boolean',
            // 'status' => 'required|boolean',
        ]);
        if(!$validator->fails()) {
            Storage::disk('public')->delete($product->image);
            $product->name = $request->input('name');
            // $product->status = $request->input('status');
            $product->subcategory_id = $request->input('subcategory_id');
            $product->description = $request->input('description');

            if ($request->hasFile('img')) {
                $image = $request->file('img');
                $imageName = Carbon::now()->format('Y_m_d_h_i') . '_' . $product->name . '.' . $image->getClientOriginalExtension();
                $request->file('img')->storeAs('/products', $imageName, ['disk' => 'public']);
                $product->img = 'products/' . $imageName;
            }
            $isSave = $product->save();

            return response()->json([
                'message' => $isSave ? 'Update successfully' : 'Update Failed'
            ], $isSave ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);

        } else {
            return response()->json([
                'message' =>   $validator->getMessageBag()->first()
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
        $imageName = $product->image;
        $deleted = $product->delete();
        if ($deleted) Storage::disk('public')->delete($imageName);
        return response()->json([
            'title' => $deleted ? 'Deleted successfully' : "Delete failed",
            'icon' => $deleted ? 'success' : "error",
        ], $deleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }


    //////// get subcategory ajax
    public function getSubcategory($id)
    {
        $subcategories = DB::table('subcategories')->where('category_id',$id)->pluck('name','id');
        return response()->json($subcategories);
    }
}
