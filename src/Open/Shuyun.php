<?php
namespace Shuyun;

use Shuyun\Open\Helper\ShuyunHelper;


class Shuyun
{
    //[数云]同步会员信息
    public static function Api($Method,$requestType,$data,$intefacetype)
    {
        
        $signdata = array(
            'Gateway-Request-Time' => ShuyunHelper::msectime()
        );
        $body  = $data;
        $res = ShuyunHelper::syRequest($Method,$signdata,$body,$intefacetype,$requestType);
        $res = json_decode($res[1],true);
        return $res;

    }

    

    
}