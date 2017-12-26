<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/23
 * Time: 20:01
 */

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function nake_excerpt($value , $length = 20)
{
    $excerpt = trim(preg_replace('/\r\n|\r|\n/',' ',strip_tags($value)));
    return str_limit($excerpt,$length);
}