<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserFeed;
use App\Article;
use App\Subscription;
use Illuminate\Support\Facades\Auth;
use App\Helpers\DatabaseHelper;

class HomeController extends Controller
{
    public function index() {
      if(!Auth::check()) {
        return redirect('/login');
      }
      new UserFeed(Auth::id());
      $myfeed = Article::join('subscriptions', 'articles.subscription_id', '=', 'subscriptions.id')->
      select('articles.id', 'articles.datetime', 'articles.title', 'articles.url', 'articles.body', 'subscriptions.title as subscription_title', 'subscriptions.favicon as subscription_favicon')->
      where('subscriptions.user_id', '=', Auth::id())->
      orderBy('datetime', 'desc')->take(15)->get();
      foreach($myfeed as $article) {
        $article->summary = DatabaseHelper::summarizeText($article->body, 200);
      }

      $subscriptions = Subscription::select('*')->where('user_id', '=', Auth::id())->limit(6)->get();

    	return view('home', ['articles' => $myfeed, 'subscriptions' => $subscriptions]);
    }
}
