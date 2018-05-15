<?php
/**
 * Created by PhpStorm.
 * User: zhao
 * Date: 2018/5/15
 * Time: 20:33
 */

namespace App\Http\Controllers\Api;


use App\Http\Requests\Api\UserRequest;
use App\Models\User;

class UsersController extends Controller
{
    public function store(UserRequest $request)
    {
        $verifyData = \Cache::get($request->verification_key);

        if(!$verifyData){
            return $this->response->error('验证码已失效',422);
        }

        if(!hash_equals($verifyData['code'],$request->verification_code)){
            return $this->response->errorUnauthorized('验证码错误');
        }

        $user = User::create([
            'name'=>$request->name,
            'phone'=>$verifyData['phone'],
            'password'=>bcrypt($request->password)
        ]);

        \Cache::forget($request->verification_key);

        return $this->response->created();
    }
}