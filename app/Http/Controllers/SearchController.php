<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Subscription;
use Illuminate\Support\Facades\Auth;
use App\Helpers\DatabaseHelper;
use App\Settings;

class SearchController extends Controller
{
    public function query(Request $request) {
        if(!Auth::check()) {
            return redirect('/login');
        }

        $q = $request->query('query');
        if($request->has('subscriptionId')) {
            $subscription_id = $request->query('subscriptionId');
        } else {
            $subscription_id = null;
        }

        if($subscription_id == null) {
            $query = Article::join('subscriptions', 'articles.subscription_id', '=', 'subscriptions.id')->
            select('articles.id', 'articles.datetime', 'articles.title', 'articles.url', 'articles.body', 'subscriptions.title as subscription_title', 'subscriptions.favicon as subscription_favicon')->
            where([
                ['subscriptions.user_id', '=', Auth::id()],
                ['articles.title', 'like', '%' . $q . '%']
            ])->
            orWhere([
                ['subscriptions.user_id', '=', Auth::id()],
                ['articles.body', 'like', '%' . $q . '%']
            ])->
            orderBy('datetime', 'desc')->take(15);
        } else {
            $query = Article::join('subscriptions', 'articles.subscription_id', '=', 'subscriptions.id')->
            select('articles.id', 'articles.datetime', 'articles.title', 'articles.url', 'articles.body', 'subscriptions.title as subscription_title', 'subscriptions.favicon as subscription_favicon')->
            where([
                ['subscriptions.user_id', '=', Auth::id()],
                ['subscriptions.id', '=', $subscription_id],
                ['articles.title', 'like', '%' . $q . '%']
            ])->
            orWhere([
                ['subscriptions.user_id', '=', Auth::id()],
                ['subscriptions.id', '=', $subscription_id],
                ['articles.body', 'like', '%' . $q . '%']
            ])->
            orderBy('datetime', 'desc')->take(15);
        }

        $results = $query->get();
        $records = $query->count();
  
        foreach($results as $article) {
            $article->summary = DatabaseHelper::summarizeText($article->body, 200);
        }

        $settings = [];
        $option = Settings::settingValue('always_open_source_of_article', Auth::id());
        $settings['always_open_source_of_article'] = $option;

        return view('search', ['articles' => $results, 'q' => $q, 'subscription_id' => $subscription_id, 'records' => $records, 'settings' => $settings, 'api_token' => Auth::user()->api_token]);
    }
}
