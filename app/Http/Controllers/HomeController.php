<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserFeed;
use App\Article;
use App\Subscription;
use Illuminate\Support\Facades\Auth;
use App\Helpers\DatabaseHelper;
use App\Settings;
use Lang;

class HomeController extends Controller
{
    public function index() {
      if(!Auth::check()) {
        return redirect('/login');
      }
      
      $myfeed = Article::join('subscriptions', 'articles.subscription_id', '=', 'subscriptions.id')->
      select('articles.id', 'articles.datetime', 'articles.title', 'articles.url', 'articles.body', 'subscriptions.title as subscription_title', 'subscriptions.favicon as subscription_favicon')->
      where('subscriptions.user_id', '=', Auth::id())->
      orderBy('datetime', 'desc')->take(15)->get();
      foreach($myfeed as $article) {
        $article->summary = DatabaseHelper::summarizeText($article->body, 200);
      }

      $subscriptions = Subscription::select('*')->where('user_id', '=', Auth::id())->limit(6)->get();

      $settings = [];
      $option = Settings::settingValue('always_open_source_of_article', Auth::id());
      $settings['always_open_source_of_article'] = $option;

      $months = array(
        'Mon'   =>  Lang::get('date.mon'),
        'Tue'   =>  Lang::get('date.tue'),
        'Wed'   =>  Lang::get('date.wed'),
        'Thu'   =>  Lang::get('date.thu'),
        'Fri'   =>  Lang::get('date.fri'),
        'Sat'   =>  Lang::get('date.sat'),
        'Sun'   =>  Lang::get('date.sun')
      );

    	return view('home', ['articles' => $myfeed, 'subscriptions' => $subscriptions, 'settings' => $settings, 'api_token' => Auth::user()->api_token, 'months' => $months]);
    }
}
