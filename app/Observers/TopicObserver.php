<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/26
 * Time: 17:28
 */

namespace App\Observers;


use App\Handlers\SlugTranslateHandler;
use App\Models\Topics;

class TopicObserver
{
    public function saving(Topics $topics)
    {
        $topics->excerpt = nake_excerpt($topics->body);

        $topics->body = clean($topics->body,'default');

        if(!$topics->slug){
            $topics->slug = app(SlugTranslateHandler::class)->translate($topics->title);
        }
    }
}