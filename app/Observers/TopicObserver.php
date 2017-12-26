<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/12/26
 * Time: 17:28
 */

namespace App\Observers;


use App\Models\Topics;

class TopicObserver
{
    public function saving(Topics $topics)
    {
        $topics->excerpt = nake_excerpt($topics->body);
    }
}