<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;

class ArticleController extends Controller
{
    public function read($article_id) {
        $query = Article::join('subscriptions', 'articles.subscription_id', '=', 'subscriptions.id')
        ->select('articles.id', 'articles.datetime', 'articles.title', 'articles.url', 'articles.body', 'subscriptions.title as subscription_title')
        ->where('articles.id', '=', $article_id)
        ->first();

        if($query) {
            return view('read', ['article' => $query]);
        }
    }
}
