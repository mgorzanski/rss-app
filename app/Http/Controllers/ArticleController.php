<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\User;

class ArticleController extends Controller
{
    public function read($article_id) {
        if(!Auth::check()) {
            return redirect('/login');
        }

        $query = Article::join('subscriptions', 'articles.subscription_id', '=', 'subscriptions.id')
        ->select('articles.id', 'articles.datetime', 'articles.title', 'articles.url', 'articles.body', 'subscriptions.title as subscription_title')
        ->where('articles.id', '=', $article_id)
        ->first();

        if($query) {
            return view('read', ['article' => $query, 'api_token' => Auth::user()->api_token]);
        }
    }

    public function saveForLater($article_id, Request $request) {
        try {
            if(!Auth::check()) {
                throw new \Exception('User not authenticated.');
            }
        } catch(\Exception $e) {
            echo $e->getMessage();
        }

        $datetime = date("Y-m-d H:i:s");
        $user_id = Auth::guard('api')->id();

        if (!DB::table('saved')->select('id')->where([
            ['article_id', '=', $article_id],
            ['user_id', '=', $user_id]
        ])->get()) {

            DB::table('saved')->insert([
                ['article_id' => $article_id, 'datetime' => $datetime, 'user_id' => $user_id]
            ]);
        } else {
            return json_encode("Already added");
        }
    }
}
