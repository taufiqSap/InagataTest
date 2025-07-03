<?php

namespace App\Http\Controllers\API;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreCategoryRequest;

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
        return CategoryResource::collection($data);
       // return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
{
    $validator = Validator::make($request->all(), [
        'category_name' => 'required|string|max:100'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => $validator->errors(),
        ], 422);
    }

    $category = new Category();
    $category->category_name = $request->category_name;
    $category->save();

    return response()->json([
        'status' => true,
        'message' => 'Data berhasil ditambah',
        'data' => new CategoryResource($category)
    ], 201);
}


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        {
            if(!$category){
                return response()->json([
                    'status' => false,
                    'message' => 'id tidak ditemukan'
                ],402);
            }
            return response()->json($category);
        }
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
        $validator = Validator($request->all(),[
            'category_name' => 'required|string|max:100'
        ]);
        
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 402);
        }else{
            $category = Category::find($id);
            $category->category_name = $request->category_name;
            $category->save();

            return response()->json([
                'status' => true,
                'message' => 'data berhasil diupdate'
            ], 201);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if(!$category){
            return response()->json([
                'message' => 'id tidak ditemukan'
            ], 404);
        }
        $category->delete();
        return response()->json([
            'status' => true,
            'message' => 'data berhasil dihapus'
        ],200);
    }
}
