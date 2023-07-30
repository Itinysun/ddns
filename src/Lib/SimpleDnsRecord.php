<?php

namespace itinysun\ddns\Lib;

class SimpleDnsRecord
{
    public function __construct(string $id,string $ip)
    {
        $this->id=$id;
        $this->ip=$ip;
    }
    public string $id;
    public string $ip;
}
