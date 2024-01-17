<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Http\Resources\ArticleResource;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ArticleResource::collection(Article::paginate(15));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        $article = $request->isMethod('put') ? Article::findOrFail($request->id) :
            new Article;

        $article->id = $request->id;
        $article->title = $request->title;
        $article->body = $request->body;

        if($article->save()){
            return new ArticleResource($article);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return new ArticleResource(Article::findOrFail($id));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        if($article->delete()) {
            return new ArticleResource($article);
        }
    }
}
