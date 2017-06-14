<?php
/**
 * Created by PhpStorm.
 * User: hongtian.li
 * Date: 2017/5/16
 * Time: 17:26
 */
namespace v300\components;
class RequestCurl{
    /**
     * curl进行post请求
     * @param string $url
     * @param array $post_data
     */
    public static function request_post($url = '',$is_post=true, $post_data = array()) {
        if (empty($url) || empty($post_data)) {
            return false;
        }
        $addition = "";
        foreach ( $post_data as $k => $v )
        {
            $addition.= "$k=" . urlencode( $v ). "&" ;
        }
        $post_data = substr($addition,0,-1);

        if($is_post){
            $url = $url;
        }else{
            $url = $url.'?'.$post_data;
        }

        header("Content-type: text/html; charset=utf-8");
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        if($is_post){
            curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        }
        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        return $data;
    }
}