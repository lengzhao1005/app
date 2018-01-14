<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/14
 * Time: 17:20
 */

namespace App\Models\Traits;


use Carbon\Carbon;
use Redis;

trait LastActiveAtHelper
{
    protected $hash_prefix = 'summer_last_active_at';
    protected $field_prefix = 'user_';

    public function recordLastActiveAt()
    {
        $data = Carbon::now()->toDateString();

        $hash = $this->getHashFromDateString($data);

        $field = $this->getHashField();

        $now = Carbon::now()->toDateTimeString();

        Redis::hSet($hash,$field,$now);
    }

    public function syncUserActiveAt()
    {
        $yestoday_date = Carbon::now()->subDay()->toDateString();

        $hash = $this->getHashFromDateString($yestoday_date);

        $datas = Redis::hGetAll($hash);

        foreach ($datas as $user_id=>$active_at){
            $user_id = str_replace($this->field_prefix,'',$user_id);

            if($user = $this->find($user_id)){
                $user->last_active_at = $active_at;
                $user->save();
            }
        }

        Redis::del($hash);
    }

    public function getLastActiveAtAttribute($value)
    {
        $data = Carbon::now()->toDateString();

        $hash = $this->getHashFromDateString($data);

        $field = $this->getHashField();

        $datatime = Redis::hGet($hash,$field)? : $value;

        if($datatime){
            return new Carbon($datatime);
        }else{
            return $this->created_at;
        }
    }

    public function getHashFromDateString($date)
    {
        // Redis 哈希表的命名，如：larabbs_last_actived_at_2017-10-21
        return $this->hash_prefix . $date;
    }

    public function getHashField()
    {
        // 字段名称，如：user_1
        return $this->field_prefix . $this->id;
    }
}