<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\DatabaseHelper;

class SavedController extends Controller
{
    public function index (Request $request) {
        if (!Auth::check()) {
            return redirect('/login');
        }

        if ($request->has('delete') && $request->has('articleId') && $request->has('savedArticleId')) {
            $query = DB::table('saved')
                        ->where('article_id', '=', $request->query('articleId'))
                        ->where('id', '=', $request->query('savedArticleId'))
                        ->where('user_id', '=', Auth::id());

            if ($query->first()) {
                $query->delete();
            }

            return redirect('/browse/saved');
        }

        $savedArticles = DB::table('saved')->select('saved.id as saved_id', 'saved.article_id as saved_article_id', 'saved.datetime as saved_datetime', 'articles.datetime as article_datetime', 'articles.title as article_title', 'subscriptions.title as subscription_title', 'subscriptions.favicon as subscription_favicon')
                            ->join('articles', 'saved.article_id', '=', 'articles.id')
                            ->join('subscriptions', 'articles.subscription_id', '=', 'subscriptions.id')
                            ->where('saved.user_id', '=', Auth::id())
                            ->orderBy('saved.datetime', 'desc')
                            ->get();

        return view('saved', ['savedArticles' => $savedArticles, 'api_token' => Auth::user()->api_token]);
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

        if (!DB::table('saved')->where([
            ['article_id', '=', $article_id],
            ['user_id', '=', $user_id]
        ])->first()) {

            $id = str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);

            DB::table('saved')->insert([
                ['id' => $id, 'article_id' => $article_id, 'datetime' => $datetime, 'user_id' => $user_id]
            ]);

            return json_encode("Added successfully");
        } else {
            return json_encode("Already added");
        }
    }
}
