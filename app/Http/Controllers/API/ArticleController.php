<?php

namespace App\Http\Controllers\API;

use pagination;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreArticleRequest;
use Illuminate\Validation\Rule;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Article::paginate(10);
        return ArticleResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        $status = false;
        $message = '';

        //validasi
        $validator = Validator::make($request->all(),[
            'title' => 'required|max:100|unique:article',
            'content' => 'required|max:500',
            'author' => 'required|max:100',
            'categories_id' => 'required'
        ]);

        //creating
        if($validator->fails()){
            $status = false;
            $message = $validator->errors();
        } else {
            $status = true;
            $message = 'data berhsail ditambah';

            $article = new Article();
            $article->title = $request->title;
            $article->content = $request->content;
            $article->author = $request->author;
            $article->categories_id = $request->categories_id;

            $article->save();
        }
        // send respon
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => new ArticleResource($article)
        ],201);



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
   public function show($id)
{
    $article = Article::find($id);
    if (!$article) {
        return response()->json([
            'message' => 'Id Artikel tidak ditemukan.'
        ], 404);
    }
    return response()->json($article);
}


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */

    public function update(StoreArticleRequest $request, $id)
    {
         //validasi
         $validator = Validator::make($request->all(),[
            'title' => [
                'required',
                'max:100',
                Rule::unique('article')->ignore($id)
            ],
            'content' => 'required|max:100',
            'author' => 'required|max:100',
            'categories_id' => 'required'
         ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ],400);
        } else{
            $article = Article::find($id);
            $article->title = $request->title;
            $article->content = $request->content;
            $article->author = $request->author;
            $article->categories_id = $request->categories_id;
            $article->save();
    
            return response()->json([
                'status' => true,
                'message' => 'data artikel berhasil di update'
            ]);
        }
    } 

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        if (!$article) {
        return response()->json([
            'message' => 'Id Artikel tidak ditemukan.'
        ], 404);
    }   
        $article->delete();

        return response()->json([
            'succes' => true,
            'message' => 'Data berhasil dihapus'
        ]);

       // $article->delete();

       // return response()->json([
           // 'succes' => true,
          //  'message' => 'berhasil menghapus'
      //  ]);
    }
}
