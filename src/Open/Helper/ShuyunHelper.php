<?php
namespace Shuyun\Open\Helper;

class  ShuyunHelper
{
         /**
         * 获取毫秒级时间
         * @return float 
         */
        public static  function msectime()
        {
            list($msec, $sec) = explode(' ', microtime());
            $msectime = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
            return $msectime;
        }
        
         /**
         * 获取序列化字符串
         ** @param $data   Array  接收到的数组
         * @return string 序列化后的字符
         */
        public  static function sortInfo($data)
        {
            ksort($data);
            $signstr = '';
            foreach($data as $k=>$v){
                $signstr .= $k.$v;
            }
            // $signstr = trim($signstr,'+');
            return $signstr;
            
        }

         /**
         * 排序url参数拼接
         ** @param $data   Array  接收到的数组
         * @return string 序列化后的字符
         */
        public  static function getUrlParams($data)
        {
            $str = '';
            if(empty($data)){
                return $str;
            }
            ksort($data);
            
            foreach($data as $k=>$v){
                $str .= $k.'='.$v.'&';
            }
            $str = trim($str,'&');
            return $str;
        }

          /**
         * 不排序url参数拼接
         ** @param $data   Array  接收到的数组
         * @return string 序列化后的字符
         */
        public static function getUrlParams2($data)
        {
            $str = '';
            if(empty($data)){
                return $str;
            }
            
            foreach($data as $k=>$v){
                $str .= $k.'='.$v.'&';
            }
            $str = trim($str,'&');
            return $str;
        }



        public static function convertUrlArray($query)
        {
            $queryParts = explode('&', $query);
            $params = array();
            foreach ($queryParts as $param) {
                $item = explode('=', $param);
                $params[$item[0]] = $item[1];
            }
            return $params;
        }

         /**
         * httpget请求
         ** @param    $url  string 接收到url
          ** @param     $headers  Array 接收到header
         * @return string object
         */
        public static function httpGet($url,$headers) 
        {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_TIMEOUT, 500);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_URL, $url);
            $res = curl_exec($curl);
            if(curl_errno($curl)){
                print curl_error($curl);
            }
            curl_close($curl);
            return $res;
        }


         /**
         * httppost请求传递json数据
         ** @param    $url  string 接收到url
         ** @param     $headers  Array 接收到header
         ** @param     $jsonStr  string 接收到json
         * @return string Array
         */
        public static function http_post_json($url,$headers,$jsonStr)
        {
            
            array_push($headers,'Content-Type: application/json; charset=utf-8');
            

            $ch = curl_init();
            
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);
            $errorno = curl_errno($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            return array($httpCode, $response);
        }

        /**
         * httppost请求传递
         ** @param    $url  string 接收到url
         ** @param     $headers  Array 接收到header
         ** @param     $Str  string 接收到str
         * @return string object
         */
        public static function http_post($url,$headers = array(),$Str)
        {
            array_push($headers,'Expect:');
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $Str);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($ch);
            // 出错则显示错误信息
            if(curl_errno($ch)){
                print curl_error($ch);
            }
            
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            return array($httpCode, $response);
        }

         /**
         * httppost请求传递
         ** @param    $url  string 接收到url
         ** @param     $params  array 接收到params
         ** @param     $headers  array 接收到str
         * @return string Array
         */
        public static function request_post($url, $params = array(), $headers)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            return array($httpCode, $response);
        }

         /**
         * httpput请求传递
         ** @param    $url  string 接收到url
         ** @param     $headers  array 接收到头
        ** @param     $jsonStr string  接收到
         * @return string Array
         */
        public static function http_put_json($url,$headers = array(),$jsonStr)
        {
            array_push($headers,'Content-Type: application/json; charset=utf-8');
            $ch = curl_init(); //初始化CURL句柄 
            curl_setopt($ch, CURLOPT_URL, $url); //设置请求的URL
            curl_setopt ($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); //设为TRUE把curl_exec()结果转化为字串，而不是直接输出 
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"PUT"); //设置请求方式
            curl_setopt($ch, CURLOPT_POSTFIELDS,$jsonStr);//设置提交的字符串
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            return array($httpCode, $response);
        }
}