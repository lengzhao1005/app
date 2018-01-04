<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/3
 * Time: 19:22
 */

namespace App\Observers;


use App\Models\Reply;
use App\Notifications\TopicReply;

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content,'default');
    }

    public function created(Reply $reply)
    {
        $reply->topic->increment('reply_count',1);

        $topic = $reply->topic;

        if($reply->user->id ){
            $topic->user->notify(new TopicReply($reply));
        }
    }
}