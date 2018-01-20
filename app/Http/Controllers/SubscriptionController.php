<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Subscription;
use App\Article;
use Illuminate\Support\Facades\Auth;
use App\Helpers\DatabaseHelper;

class SubscriptionController extends Controller
{
    public function index(Request $request) {
      if(!Auth::check()) {
        return redirect('/login');
      }

      if(!$request->has('action')) {
        $feeds = Subscription::select('*')->where('user_id', '=', Auth::id())->orderBy('id')->get();
      	return view('feeds.index', ['feeds' => $feeds]);
      }
      elseif($request->query('action') == "add")
        return $this->add($request);
      elseif($request->query('action') == "edit")
        return $this->edit($request);
      elseif($request->query('action') == "delete")
        return $this->delete($request);
      elseif($request->query('action') == "refresh")
        return $this->update($request);
    }

    public function browse($subscription_id) {
      if(!Auth::check()) {
        return redirect('/login');
      }

      if($subscription_id != null) {
        $articles = Article::join('subscriptions', 'articles.subscription_id', '=', 'subscriptions.id')->
        select('articles.id', 'articles.datetime', 'articles.title', 'articles.url', 'articles.body', 'subscriptions.title as subscription_title', 'subscriptions.favicon as subscription_favicon')->
        where('subscriptions.id', '=', $subscription_id)->
        orderBy('datetime', 'desc')->take(15)->get();
        $subscription = Subscription::select('*')->where('id', '=', $subscription_id)->first();

        return view('feeds.subscription', ['articles' => $articles, 'subscription' => $subscription, 'api_token' => Auth::user()->api_token]);
      }
    }

    public function add(Request $request) {
      return view('feeds.add');
    }

    public function edit(Request $request) {
      if($request->has('subscriptionId')) {
        if(Subscription::select('id', 'user_id')->where('id', '=', $request->query('subscriptionId'))->where('user_id', '=', Auth::id())->first()) {
          $subscription = Subscription::select('*')->where('id', '=', $request->query('subscriptionId'))->first();
          return view('feeds.edit', ['subscription' => $subscription]);
        }
      }
    }

    public function delete(Request $request) {
      if($request->has('subscriptionId')) {
        if(Subscription::select('id', 'user_id')->where('id', '=', $request->query('subscriptionId'))->where('user_id', '=', Auth::id())->first()) {
          Subscription::select('*')->where('id', '=', $request->query('subscriptionId'))->delete();
          Article::select('*')->where('subscription_id', '=', $request->query('subscriptionId'))->delete();
          return redirect('/browse/feeds');
        }
      }
    }

    public function update(Request $request) {
      if($request->has('subscriptionId')) {
        if(Subscription::select('id', 'user_id')->where('id', '=', $request->query('subscriptionId'))->where('user_id', '=', Auth::id())->first()) {
          $subscription_id = $request->query('subscriptionId');
          $subscription = Subscription::select('*')->where('id', '=', $subscription_id)->first();
          $website_address = parse_url($subscription['rss_url']);
          $website_address = $website_address['scheme'] . '://' . $website_address['host'] . '/';
          $this->updateTitle($subscription_id, $website_address);
          $this->updateFavicon($subscription_id, $website_address);
          return redirect('/browse/feeds');
        }
      }
    }

    public function updateFavicon($subscription_id, $website_address) {
      $doc = new \DOMDocument();
      $doc->strictErrorChecking = false;
      @$doc->loadHTML(file_get_contents($website_address));
      $xml = simplexml_import_dom($doc);
      $arr = $xml->xpath('//link[@rel="shortcut icon"]');
      $arr2 = $xml->xpath('//link[@type="image/x-icon"]');
      if(array_key_exists(0, $arr)) {
        $favicon = $arr[0]['href'];
        if (strpos($favicon, 'ttp') == false) {
          $favicon = $website_address . $favicon;
        }
      } elseif(array_key_exists(0, $arr2)) {
        $favicon = $arr2[0]['href'];
        if (strpos($favicon, 'ttp') == false) {
          $favicon = $website_address . $favicon;
        }
      } else {
        $favicon = '';
      }

      if($subscription_id == null) {
        return $favicon;
      } else {
        Subscription::where('id', $subscription_id)->update(['favicon' => $favicon]);
      }
    }

    public function updateTitle($subscription_id, $website_address) {
      $doc = new \DOMDocument();
      $doc->strictErrorChecking = false;
      @$doc->loadHTML(file_get_contents($website_address));
      $xpath = new \DOMXPath($doc);
      $title = $xpath->query('//title')->item(0)->nodeValue."\n";

      if($subscription_id == null) {
        return $title;
      } else {
        Subscription::where('id', $subscription_id)->update(['title' => $title]);
      }
    }

    public function manage(Request $request) {
      if($request->isMethod('post')) {
        if($request->has(['title', 'url', 'action'])) {
          $title = $request->input('title');
          $url = $request->input('url');

          if(is_null($title)) {
            $title = $this->updateTitle(null, $url);
          }

          if($request->input('action') == "edit") {
            $query = Subscription::select('rss_url')->where('rss_url', '=', $url)->first();
            if($query) {
              Subscription::where('id', $request->input('id'))->update(['title' => $title, 'rss_url' => $url]);
            }
          } elseif($request->input('action') == "add") {
            do {
              $id = str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);
              $query = Subscription::select('id')->where('id', '=', $id);
            } while(!$query && $id > "01000000");
  
            $website_address = parse_url($url);
            $website_address = $website_address['scheme'] . '://' . $website_address['host'] . '/';
            $favicon = $this->updateFavicon(null, $website_address);

            Subscription::insert(
                ['id' => $id, 'title' => $title, 'rss_url' => $url, 'favicon' => $favicon, 'user_id' => Auth::id()]
            );

            \Artisan::call('userfeed:update');
          }

          return redirect('/browse/feeds');
        }
      }
    }
}
