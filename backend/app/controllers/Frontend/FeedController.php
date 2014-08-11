<?php namespace Controllers\Frontend;

use Controllers\FrontBaseController;
use Article as ArticleModel;
use Catagory as CatagoryModel;
use Article_catagory as Article_catagoryModel;
use View;
use Config;
use Feed;
use URL;
use strFilter;

class FeedController extends FrontBaseController {

    /**
     * Frontend Feed Page
     *
     * @return XML
     */
    public function showFeed()
    {
        $posts = ArticleModel::orderBy('created_at', 'desc')->take(50)->get();
        $feed = Feed::make();

        $feed->title = Config::get('freshman.freshmanTitle');
        $feed->description = Config::get('freshman.freshmanDescription');
        $feed->logo = Config::get('freshman.freshmanLogoSite');
        $feed->link = URL::to('feed');
        $feed->pubdate = $posts[0]->created_at;
        $feed->lang = 'zh-cn';

        foreach ($posts as $post) {
            $postId = ArticleModel::find($post->id);
            $catagory = $postId->catagories()->get();
            $url = URL::to('article/'.$catagory[0]['id'].'/'.$post->id);
            $desciption = strFilter::filterHtmlLimit($post->content,Config::get('freshman.substrLength'));

            $feed->add($post->title, $post->user, $url, $post->created_at, $desciption, $post->content);
        }

        return $feed->render('rss');
    }
}

