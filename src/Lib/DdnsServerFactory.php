<?php

namespace itinysun\ddns\Lib;

use Exception;
use itinysun\ddns\Models\DdnsDomain;

class DdnsServerFactory
{
    /**
     * @throws Exception
     */
    public static function getServer(DdnsDomain $domain):DdnsServerInterface{
        return match ($domain->cloud){
            'ali'=>new AliDns($domain),
            'qcloud'=>new QcloudDns($domain),
            'default'=>throw new Exception('driver not found! '.$domain->cloud)
        };
    }
}
