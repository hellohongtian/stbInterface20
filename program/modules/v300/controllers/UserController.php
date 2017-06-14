<?php

namespace app\modules\v300\controllers;

use v300\components\InterfaceController;
use v300\components\thriftClient\ThriftClient;
use Thrift\Exception\TException;
use v300\components\error\ErrorAction;
use v300\components\GetClientIP;

class UserController  extends InterfaceController
{
    /**
     * 用户登录接口
     */
    public function actionLogin()
    {
        $mac = $this->params['mac'];
        $version = $this->params['ota_version'];
        $language = "zh_CN";
        $user_ip = GetClientIP::getClientIP();
       try{
           $thriftClient = ThriftClient::instance('auth');
           $result = $thriftClient->login($mac,$version,$language,$user_ip);
       }catch (TException $e){
           ErrorAction::getInstance()->throwError("default_error");
       }
        $data['token'] = $result->token;
        $data['token_expire'] = $result->token_expire;
        $data['userid'] = $result->userid;
        $data['location'] = $result->local;
        $data['timezone_offset'] = $result->timezone_offset;

        return ['result' => $data];

    }

    /**
     * 获取用户信息接口
     */
    public function actionInfo()
    {

        $mac = $this->params['mac'];
        $version = $this->params['ver'];
        $language = $this->params['lan'];
        $user_ip = $this->params['user_ip'];

        try{
            $thriftClient = ThriftClient::instance('auth');
            $result = $thriftClient->login($mac,$version,$language,$user_ip);
        }catch (TException $e){
            ErrorAction::getInstance()->throwError("default_error");
        }

        $data['userid'] = $result->userid;
        $data['status_info'] = $result->status;

        if($data['status_info'] == 2){
            $data['status_info'] = "激活";
        }elseif($data['status_info'] == 3){
            $data['status_info'] = "禁用";
        }elseif($data['status_info'] == 0){
            $data['status_info'] ="未使用";
        }

        $data['expire'] = 123;

        return ['result' => $data];
    }
}
