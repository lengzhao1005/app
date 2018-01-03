<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/3
 * Time: 19:22
 */

namespace App\Observers;


use App\Models\Reply;

class ReplyObserver
{
    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content,'default');
    }

    public function created(Reply $reply)
    {
        $reply->topic->increment('reply_count',1);
    }
}