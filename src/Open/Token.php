<?php
namespace Shuyun;

use Shuyun\Open\Config\ShuyunConfig;
use Shuyun\Open\Config\HttpConfig;
use Shuyun\Open\Helper\ShuyunHelper;


class Token
{

     //【数云】获取access_token
     public static function GetSyAccessToken()
     {
         $msg = array();
        
         $url = HttpConfig::REQUEST_TOKEN_URL.'/client/callback/token/'.ShuyunConfig::ENV_APPID.'/v2';
        
     
         $headers = array(
             "Content-Type →text/html; charset=UTF-8"
         );
 
         $resinfo = ShuyunHelper::httpGet($url,$headers);
       
         $res = json_decode($resinfo,true);
         
         switch($res['code']){
             case 200:
              
                 $msg['status'] = "success";
                 $msg['title'] = '【数云】刷新access_token请求成功'; 
                 $msg['content'] = '【数云】最新的Token为'.$res['data']['tokenList'][0]['accessToken']."   isOverDue:".$res['data']['tokenList'][0]['isOverDue'];
                 $msg['accessToken'] = $res['data']['tokenList'][0]['accessToken'];
                 break;
             case 400:
               
                 $msg['status'] = "error";
                 $msg['title'] = '【数云】刷新access_token请求失败'; 
                 $msg['content'] = '错误码'.$res['code'].",错误信息:".$res['msg']; 
                 $msg['accessToken']="";
                 break;
             default:
                
                 $msg['status'] = "error";
                 $msg['title'] = '【数云】刷新access_token请求失败'; 
                 $msg['content'] = '错误码'.$res['code'].",错误信息:".$res['message']; 
                 $msg['accessToken']="";
         }
    
         return $msg;
    }

    //【数云】回调获取access_token
    public static function notifyGetSyAccessToken(Request $request)
    {
        
        $message = file_get_contents('php://input');
        
        $checkdata = array();
         
         //url携带的参数
         $callBackTime = $message['callBackTime'];
         $sign = $message['sign'];
        
         $checkdata['callBackTime'] = $callBackTime;
       
        
         
        ///进行验签
        $token = new Token();
        if(!$token->checkSySign($checkdata,$sign)){
            $msg['status'] = "error";
			$msg['title'] = '【数云】验签失败';
			$msg['content'] = '错误信息：验签失败';
			$msg['access_token'] = '';
           return $msg;
        }

         //body体回调的参数
         $body = $message;
         
		 //[{"isOverDue":0,"authValue":"msmin","appId":"1911255926d24cb28aa4aaeb338fd1ac","authType":0,"accessToken":"RkMwOUM2NjU4NEY1NDY0MEZBQjJBMTlBOTM1RkJGMEM"}]
         
		//1代表token已过期，如果是授权过期，则需要租户在页面进行手动授权，产生新accessToken
		if(isset($body[0]['isOverDue']) && $body[0]['isOverDue'] ==1){
			Log::info("[数云回调]错误信息：access_token已过期,如果是授权过期，则需要租户在页面进行手动授权，产生新accessToken".PHP_EOL);
			$msg['status'] = "error";
			$msg['title'] = '【数云】回调获取access_token错误';
			$msg['content'] = '错误信息：access_token已过期,如果是授权过期，则需要租户在页面进行手动授权，产生新accessToken';
			$msg['access_token'] = '';
		}

		//0代表已更新
		if(isset($body[0]['isOverDue'])){
			$access_token = $body[0]['accessToken'];
			//Log::info("【数云回调】刷新获取token成功:".$access_token.PHP_EOL);
			//计算过期时间,token有效时间为3天
			$expires_time =  HttpConfig::TOKEN_EXPIRES*86400 - 3600;
			//缓存token
			
			$msg['status'] = "success";
			$msg['title'] = '【数云回调】回调获取access_token成功';
            $msg['content'] = '【数云回调】新accessToken为'.$access_token;
            $msg['access_token'] = $access_token;
		}else{
			
			$msg['status'] = "err";
			$msg['title'] = '【数云回调】回调获取access_token失败';
            $msg['content'] = '【数云回调】刷新获取token失败,回调信息为空';
            $msg['access_token'] = '';
		}

         
        return $msg;
    }

      //[数云]签名
    public static function getSySign($data,$body=null)
    {
        
        if($body!=null){
            $data = array_merge($data,$body);
           
        }
        $str = sortInfo($data);
        
        $signstr = ShuyunConfig::ENV_SECURITY.$str.ShuyunConfig::ENV_SECURITY;
        
        return md5($signstr);
    }

    //数云验签
    public  function checkSySign($data,$sign)
    {
        
        $str = sortInfo($data);
        $thissign = md5(ShuyunConfig::ENV_SECURITY.$str.ShuyunConfig::ENV_SECURITY);
      
        if($thissign==$sign){
            
            return true;
        }
        
        return false;
    }
}