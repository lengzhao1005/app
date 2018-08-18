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
use App\Models\Topic;

class TopicObserver
{
    public function saving(Topic $topics)
    {
        $topics->excerpt = nake_excerpt($topics->body);

        $topics->body = clean($topics->body,'default');
    }

    public function saved(Topic $topics)
    {
        if(!$topics->slug){
            dispatch(new TranslateSlug($topics));
        }
    }

    public function deleted(Topic $topics)
    {
        \DB::table('replies')->where('topic_id',$topics->id)->delete();
    }
}