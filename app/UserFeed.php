<?php

namespace App;

use App\Subscription;
use App\Article;
use App\Helpers\NewID;
use willvincent\Feeds\FeedsServiceProvider;

class UserFeed {

  function __construct($user_id) {
      $subscriptions = array();
      $subscriptions = Subscription::select('id', 'title', 'rss_url')->where('user_id', '=', $user_id)->get();

      foreach($subscriptions as $subscription) {
        $feed = \Feeds::make($subscription->rss_url);
        $data = array(
          'subscription_id' => $subscription->id,
          'subscription_title' =>  $subscription->title,
          'subscription_url' =>  $subscription->rss_url,
          'items' => $feed->get_items(),
        );

        foreach($data['items'] as $item) {
          $query = Article::select('id')->where('url', '=', $item->get_permalink())->first();

          if(!$query) {
            do {
              $article_id = NewID::getStringId(37);
              $query = Article::select('id')->where('id', '=', $article_id);
            } while(!$query);

            $datetime = date('Y-m-d H:i:s', strtotime($item->get_date()));
            $body = preg_replace('/class=".*?"/','', trim($item->get_description()));
            $article = Article::insert(
              ['id' => $article_id, 'datetime' => $datetime, 'title' => $item->get_title(), 'url' => $item->get_permalink(), 
              'subscription_id' => $data['subscription_id'], 'body' => $body]
            );
          }
        }
      }
  }
}

?>
