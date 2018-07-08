<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AuthorizationRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorizationsController extends Controller
{
    public function socialStore($type,AuthorizationRequest $request)
    {
        if (!in_array($type, ['weixin'])) {
            return $this->response->errorBadRequest();
        }

        $driver = \Socialite::driver($type);

        try{
            if($code = $request->code){
                $reponse = $driver->getAccessTokenResponse($code);
                $token = array_get($reponse,'access_token');
            }else{
                $token = $request->access_token;

                if($type='weixin'){
                    $driver->setOpenId($request->openid);
                }
            }

            $authUser = $driver->userFromToken($token);
        }catch (\Exception $e){
            return $this->response->errorUnauthorized('参数错误，未获取用户信息');
        }


        switch ($type){
            case 'weixin':
                $unionid = $authUser->offsetExists('unionid')?$authUser->offsetGet('unionid'):null;

                if ($unionid) {
                    $user = User::where('weixin_unionid', $unionid)->first();
                } else {
                    $user = User::where('weixin_openid', $authUser->getId())->first();
                }

                // 没有用户，默认创建一个用户
                if (!$user) {
                    $user = User::create([
                        'name' => $authUser->getNickname(),
                        'avatar' => $authUser->getAvatar(),
                        'weixin_openid' => $authUser->getId(),
                        'weixin_unionid' => $unionid,
                    ]);
                }

                break;
        }

        return $this->response->array(['token' => $user->id]);
    }
}
