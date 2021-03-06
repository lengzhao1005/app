<?php

namespace App\Models;

use App\Moldes\Category;

class Topic extends Model
{
    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function link($param = [])
    {
        return route('topics.show',array_merge([$this->id,$this->slug],$param));
    }

    public function replies()
    {
        return $this->hasMany(Reply::class,'topic_id','id');
    }
}
