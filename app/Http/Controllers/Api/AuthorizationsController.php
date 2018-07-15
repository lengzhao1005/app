<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\AuthorizationRequest;
use App\Http\Requests\Api\SocialAuthorizationRequest;
use App\Models\User;

class AuthorizationsController extends Controller
{
    public function socialStore($type, SocialAuthorizationRequest $request)
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

        $token = \Auth::guard('api')->formUser($user);
        return $this->responseWithToken($token)->setStatusCode(201);
    }

    public function store(AuthorizationRequest $request)
    {
        $username = $request->username;

        filter_var($username, FILTER_VALIDATE_EMAIL) ?
            $credenttails['email'] = $username :
            $credenttails['phone'] = $username ;

        $credenttails['password'] = $request->password;

        if(!$token = \Auth::guard('api')->attempt($credenttails)){
            return $this->response->errorUnauthorized('用户名或密码错误');
        }

        return $this->responseWithToken($token)->setStatusCode(201);
    }

    protected function responseWithToken($token)
    {
        return $this->response->array([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => \Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }

    public function update()
    {
        $token = Auth::guard('api')->refresh();
        return $this->responseWithToken($token);
    }

    public function destory()
    {
        Auth::guard('api')->logout();
        return $this->response->noContent();
    }
}
