<?php
/**
 * Created by PhpStorm.
 * User: hongtian.li
 * Date: 2017/5/18
 * Time: 11:16
 */
namespace v300\components;

class GetClientIP{

    /**
     * 获取客户端ip
     */
    public static function getClientIP() {

        $ip = "unknown";
        /*
        * 访问时用localhost访问的，读出来的是“::1”是正常情况。
        * ：：1说明开启了ipv6支持,这是ipv6下的本地回环地址的表示。
        * 使用ip地址访问或者关闭ipv6支持都可以不显示这个。
        * */
        if (isset($_SERVER)) {
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } elseif (isset($_SERVER["HTTP_CLIENT_ip"])) {
                $ip = $_SERVER["HTTP_CLIENT_ip"];
            } else {
                $ip = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR')) {
                $ip = getenv('HTTP_X_FORWARDED_FOR');
            } elseif (getenv('HTTP_CLIENT_ip')) {
                $ip = getenv('HTTP_CLIENT_ip');
            } else {
                $ip = getenv('REMOTE_ADDR');
            }
        }

        $ipArray = explode(',',$ip);

        if(trim($ipArray[0])=="::1"){
            $ip="127.0.0.1";
        }else{
            $ip = $ipArray[0];
        }
        return $ip;
    }

}