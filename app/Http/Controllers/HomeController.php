<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserFeed;
use App\Article;
use App\Subscription;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index() {
      if(!Auth::check()) {
        return redirect('/login');
      }
      //$feed = new UserFeed(Auth::id());
      $myfeed = Article::join('subscriptions', 'articles.subscription_id', '=', 'subscriptions.id')->
      select('articles.id', 'articles.datetime', 'articles.title', 'articles.url', 'articles.body', 'subscriptions.title as subscription_title', 'subscriptions.favicon as subscription_favicon')->
      where('subscriptions.user_id', '=', Auth::id())->
      orderBy('datetime', 'desc')->take(15)->get();
      foreach($myfeed as $article) {
        $article->summary = $this->summarizeText($article->body);
      }

      $subscriptions = Subscription::select('*')->where('user_id', '=', Auth::id())->limit(6)->get();

    	return view('home', ['articles' => $myfeed, 'subscriptions' => $subscriptions]);
    }

    public function summarizeText($summary) {
      $summary = strip_tags($summary);
      $max_len = 200;
      if(strlen($summary) > $max_len)
        $summary = substr($summary, 0, $max_len) . '...';
  
      return $summary;
    }

    public function loadDataAjax(Request $request) {
      $output = '';
      $id = $request->id;

      $articles = Article::join('subscriptions', 'articles.subscription_id', '=', 'subscriptions.id')->
      select('articles.id', 'articles.datetime', 'articles.title', 'articles.url', 'articles.body', 'subscriptions.title as subscription_title', 'subscriptions.favicon as subscription_favicon')->
      where('subscriptions.user_id', '=', Auth::id())->
      orderBy('datetime', 'desc')->skip($id)->take(10)->get();

      if(!$articles->isEmpty()) {
        foreach($articles as $article) {
          $id++;
          $summary = $this->summarizeText($article->body);
          $datetime = substr($article->datetime, 0, -3);
          $output .= '<article class="feed-article" id="feed-item-' . $id . '">
                        <a href="/browse/article/' . $article->id . '">
                          <div class="feed-article-subscription-thumbnail">
                            <img src="' . $article->subscription_favicon . '" alt="' . $article->subscription_title . '">
                          </div>
                          <div class="feed-article-heading">
                            <h4 class="feed-article-title">' . $article->title . '</h4>
                          </div>
                          <div class="feed-article-intro">
                            <p>' . $summary . '</p>
                          </div>
                          <div class="feed-article-meta">
                            <p>' . $article->subscription_title . ', ' . $datetime . '</p>
                          </div>
                        </a>
                      </article>';
        }

        $output .= '<div class="more-articles-btn"><a href="#" id="load-articles" class="more-articles-link" data-id="' . $id . '">Load more</a></div>';

        echo $output;
      }
  }
}
