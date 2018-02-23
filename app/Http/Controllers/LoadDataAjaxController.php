<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use Illuminate\Support\Facades\Auth;
use App\Helpers\DatabaseHelper;
use App;
use Config;
use Lang;
use App\Settings;

class LoadDataAjaxController extends Controller
{
    public function index(Request $request) {
        try {
            if(!Auth::check()) {
                throw new \Exception('User not authenticated.');
            }
        } catch(\Exception $e) {
            echo $e->getMessage();
        }

        try {
            $locale = Auth::user()->lang;
            App::setLocale($locale);
        } catch (\Exception $e) {
            App::setLocale(Config::get('app.locale'));
        }
      
        $id = $request->input('id');
        $feed = $request->input('feed');
        $subscription_id = $request->input('subscription_id');
        $query = $request->input('query');

        if(!empty($subscription_id) && $feed == 'subscription') {
            $articles = Article::join('subscriptions', 'articles.subscription_id', '=', 'subscriptions.id')->
            select('articles.id', 'articles.datetime', 'articles.title', 'articles.url', 'articles.body', 'subscriptions.title as subscription_title', 'subscriptions.favicon as subscription_favicon')->
            where('subscriptions.id', '=', $subscription_id)->
            orderBy('datetime', 'desc')->skip($id)->take(10)->get();
        } elseif($feed == 'homepage') {
            $articles = Article::join('subscriptions', 'articles.subscription_id', '=', 'subscriptions.id')->
            select('articles.id', 'articles.datetime', 'articles.title', 'articles.url', 'articles.body', 'subscriptions.title as subscription_title', 'subscriptions.favicon as subscription_favicon')->
            where('subscriptions.user_id', '=', Auth::id())->
            orderBy('datetime', 'desc')->skip($id)->take(10)->get();
        } elseif($feed == 'search' && !empty($query) && $subscription_id === null) {
            $articles = Article::join('subscriptions', 'articles.subscription_id', '=', 'subscriptions.id')->
            select('articles.id', 'articles.datetime', 'articles.title', 'articles.url', 'articles.body', 'subscriptions.title as subscription_title', 'subscriptions.favicon as subscription_favicon')->
            where([
              ['subscriptions.user_id', '=', Auth::id()],
              ['articles.title', 'like', '%' . $query . '%']
            ])->
            orWhere([
                ['subscriptions.user_id', '=', Auth::id()],
                ['articles.body', 'like', '%' . $query . '%']
            ])->
            orderBy('datetime', 'desc')->skip($id)->take(10)->get();
        } elseif ($feed === 'search' && !empty($query) && !empty($subscription_id)) {
            $articles = Article::join('subscriptions', 'articles.subscription_id', '=', 'subscriptions.id')->
            select('articles.id', 'articles.datetime', 'articles.title', 'articles.url', 'articles.body', 'subscriptions.title as subscription_title', 'subscriptions.favicon as subscription_favicon')->
            where([
                ['subscriptions.user_id', '=', Auth::id()],
                ['subscriptions.id', '=', $subscription_id],
                ['articles.title', 'like', '%' . $query . '%']
            ])->
            orWhere([
                ['subscriptions.user_id', '=', Auth::id()],
                ['subscriptions.id', '=', $subscription_id],
                ['articles.body', 'like', '%' . $query . '%']
            ])->
            orderBy('datetime', 'desc')->skip($id)->take(10)->get();
        }

        $settings = [];
        $option = Settings::settingValue('always_open_source_of_article', Auth::id());
        $settings['always_open_source_of_article'] = $option;
  
        $output = '';
        if(!$articles->isEmpty()) {
          foreach($articles as $article) {
            $id++;
            $summary = DatabaseHelper::summarizeText($article->body, 200);
            $datetime = substr($article->datetime, 0, -3);
            if (!empty($article->subscription_favicon)) {
                $output .= '<article class="feed-article" id="feed-item-' . $id . '">';
                if ($settings['always_open_source_of_article'] === 'on') {
                    $output .= '<a href="' . $article->url . '">';
                } else {
                    $output .= '<a href="/browse/article/' . $article->id . '">';
                }
                $output .= '    <div class="feed-article-subscription-thumbnail">
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
                } else {
                    $output .= '<article class="feed-article" id="feed-item-' . $id . '">';
                    if ($settings['always_open_source_of_article'] === 'on') {
                        $output .= '<a href="' . $article->url . '">';
                    } else {
                        $output .= '<a href="/browse/article/' . $article->id . '">';
                    }
                    $output .= '        <div class="feed-article-heading">
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
            }
  
          $output .= '<div class="more-articles-btn"><a href="#" id="load-articles" class="more-articles-link" data-id="' . $id . '">' . Lang::get('feed.load-more-articles-btn') . '</a></div>';
  
          echo $output;
        }
      }
}
