<?php


namespace Shuyun\Open\Config;


class HttpConfig
{

    const REQUEST_URL = 'http://open-api.shuyun.com';

    const REQUEST_TOKEN_URL = 'http://open-client.shuyun.com';

    const TOKEN_EXPIRES = 3;

    public static function getHttpHeaders()
    {
        return [
            'User-Agent' => sprintf(self::$formatUserAgent, CommonConfig::SDK_VERSION),
        ];
    }

}