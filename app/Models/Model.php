<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as baseModel;

class Model extends baseModel
{
    public function scopeWithOrder($query,$order)
    {
        switch($order){
            case 'recent':
                $query = $this->recent();
                break;
            default:
                $query = $this->recentReplied();
                break;
        }

        return $query->with('user','category');
    }

    public function ScopeRecent($query)
    {
        return $query->orderBy('created_at','desc');
    }

    public function ScopeRecentReplied($query)
    {
        return $query->orderBy('updated_at','desc');
    }
}
