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