<?php

namespace itinysun\ddns\Lib;

use itinysun\ddns\Models\DdnsDomain;

interface DdnsServerInterface
{
    public function __construct(DdnsDomain $domain);
    public function find():?SimpleDnsRecord;
    public function update(SimpleDnsRecord $record);
    public function create(string $ip);
}
