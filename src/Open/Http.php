<?php
namespace Shuyun;

use Shuyun\Open\Config\ShuyunConfig;
use Shuyun\Open\Config\HttpConfig;
use Shuyun\Open\Helper\ShuyunHelper;
use Shuyun\Token;


class Http
{
    //[数云]公用请求方式
    public static function syRequest($Method,$signdata,$body,$intefacetype,$requestType)
    {
       
        $sytoken = self::syToken();
        if(empty($sytoken) || $sytoken==''){
            return false;
        }
        if($requestType=="Get"){
           $sign = Token::getSySign($signdata,$body);
        }else{
           $sign = Token::getSySign($signdata);
        }
        

        $url = HttpConfig::REQUEST_URL;
        //请求头信息
        $headers = array(
            'Gateway-Authid:'.ShuyunConfig::ENV_APPID,
            'Gateway-Request-Time:'.$signdata['Gateway-Request-Time'],
            'Gateway-Sign:'.$sign,
            'Gateway-Action-Method:'.$Method,
            'Gateway-Access-Token:'.$sytoken,
            'platform:offline'
        );
        

        //如果body不为空，代表需要post请求
        switch($requestType){

            case "Post":
                $jsonstr = json_encode($body);
                $resinfo = ShuyunHelper::http_post_json($url,$headers,$jsonstr);
                break;
            case "Put":
                $jsonstr = json_encode($body);
                $resinfo =  ShuyunHelper::http_put_json($url,$headers,$jsonstr); 
                break;
            default:
                //否则为get请求
                $getstr = ShuyunHelper::getUrlParams($body);
                $url = $url."?".$getstr;
                $resinfo = ShuyunHelper::httpGet($url,$headers);

        }
       
        if(is_array($resinfo)){
            return $resinfo;
        }
        $res = json_decode($resinfo,true);
        
        return $res;
       
    }

    //[数云]获取access_token
    public static function syToken()
    {
        return Token::GetSyAccessToken();
    }
}