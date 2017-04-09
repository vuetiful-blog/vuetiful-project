<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use cebe\markdown\GithubMarkdown;
use App\Http\Services\ArticleService;
use App\Article;
use App\Http\Requests\ArticleRequest;

class ArticlesController extends Controller
{
    protected $articleService;

    function __construct(ArticleService $articleService){
       $this->articleService = $articleService;
    }

    public function store(ArticleRequest $request){
        $request['formatted_article'] = $this->articleService->renderArticle($request->article);
        $request['slug'] = str_slug($request['title']);
        Article::create($request->all());
    }

    public function preview(Request $request){
        return $this->articleService->renderArticle($request->article);
    }

}
