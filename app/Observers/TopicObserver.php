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

    public function deleted(Topics $topics)
    {
        \DB::table('replies')->where('topic_id',$topics->id)->delete();
    }
}