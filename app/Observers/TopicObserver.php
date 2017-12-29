<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/26
 * Time: 17:28
 */

namespace App\Observers;


use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;
use App\Models\Topics;

class TopicObserver
{
    public function saving(Topics $topics)
    {
        $topics->excerpt = nake_excerpt($topics->body);

        $topics->body = clean($topics->body,'default');
    }

    public function saved(Topics $topics)
    {
        if(!$topics->slug){
            dispatch(new TranslateSlug($topics));
        }
    }
}