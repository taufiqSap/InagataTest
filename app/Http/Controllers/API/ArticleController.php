<?php

namespace App\Http\Controllers\API;

use pagination;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreArticleRequest;

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
        $validated = $request->validate([
            'title' => 'required|string|max:100',
            'content' => 'required|string|max:500',
            'author' => 'required|string|max:100',
            'categories_id' => 'required|exists:categories,id'
        ]);

        $article = Article::create([
             'title' => $validated['title'],
             'content' => $validated['content'],
             'author' => $validated['author'],
             'categories_id' => $validated['categories_id']

        ]);
        return response()->json([
            'succes' => true,
            'message' => 'Berhasil ditambahkan',
            'data' => $article
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Article::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */

     public function update(Request $request, $id)
     {
        $article = Article::find($id);
        if (!$article) {
            return response()->json(['message' => 'Article not Found'], 404);
        }

         $validated = $request->validate([
            'title' => 'required|string|max:100',
            'content' => 'required|string|max:500',
            'author' => 'required|string|max:100',
            'categories_id' => 'required|exists:categories,id'
        ]);

        $article = Article::update([
             'title' => $validated['title'],
             'content' => $validated['content'],
             'author' => $validated['author'],
             'categories_id' => $validated['categories_id']

        ]);
        return response()->json([
            'succes' => true,
            'message' => 'Berhasil ditambahkan',
            'data' => $article
        ]);
     }
   /* public function update(StoreArticleRequest $request, Article $article)
    {
         $validated = $request->validate([
            'title' => 'required|string|max:100',
            'content' => 'required|string|max:500',
        ]);

        $article = Article::update([
             'title' => $validated['title'],
             'content' => $validated['content'],

        ]);

        return response()->json($article);
       /* return response()->json([
            'succes' => true,
            'message' => 'Berhasil ditambahkan',
            'data' => $article
        ]);
     } */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
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
