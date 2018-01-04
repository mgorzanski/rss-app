<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Illuminate\Support\Facades\Auth;
use App\Helpers\DatabaseHelper;

class LoadDataAjaxController extends Controller
{
    public function index(Request $request) {
        $id = $request->id;
        $feed = $request->feed;

        if($request->has('subscription_id') && $feed == 'subscription') {
            $subscription_id = $request->subscription_id;
            $articles = Article::join('subscriptions', 'articles.subscription_id', '=', 'subscriptions.id')->
            select('articles.id', 'articles.datetime', 'articles.title', 'articles.url', 'articles.body', 'subscriptions.title as subscription_title', 'subscriptions.favicon as subscription_favicon')->
            where('subscriptions.id', '=', $subscription_id)->
            orderBy('datetime', 'desc')->skip($id)->take(10)->get();
        } elseif($feed == 'homepage') {
            $articles = Article::join('subscriptions', 'articles.subscription_id', '=', 'subscriptions.id')->
            select('articles.id', 'articles.datetime', 'articles.title', 'articles.url', 'articles.body', 'subscriptions.title as subscription_title', 'subscriptions.favicon as subscription_favicon')->
            where('subscriptions.user_id', '=', Auth::id())->
            orderBy('datetime', 'desc')->skip($id)->take(10)->get();
        }
  
        $output = '';
        if(!$articles->isEmpty()) {
          foreach($articles as $article) {
            $id++;
            $summary = DatabaseHelper::summarizeText($article->body, 200);
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
