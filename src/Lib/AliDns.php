<?php

namespace itinysun\ddns\Lib;

use AlibabaCloud\SDK\Alidns\V20150109\Alidns as AlidnsClient;
use AlibabaCloud\SDK\Alidns\V20150109\Models\AddDomainRecordRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\DescribeDomainRecordsRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\UpdateDomainRecordRequest;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use Darabonba\OpenApi\Models\Config;
use itinysun\ddns\Models\DdnsDomain;
use Exception;

class AliDns implements DdnsServerInterface
{
    protected AlidnsClient $client;
    protected DdnsDomain $domain;
    public function __construct(DdnsDomain $domain)
    {
        $config = new Config([
            // 必填，您的 AccessKey ID
            "accessKeyId" => $domain->appid,
            // 必填，您的 AccessKey Secret
            "accessKeySecret" => $domain->secret
        ]);
        // Endpoint 请参考 https://api.aliyun.com/product/Alidns
        $config->endpoint = "alidns.cn-beijing.aliyuncs.com";
        $this->client = new AlidnsClient($config);
        $this->domain=$domain;
    }

    public function find(): ?SimpleDnsRecord
    {
        $describeDomainRecordsRequest = new DescribeDomainRecordsRequest([
            "domainName" => $this->domain->domain_base,
            "keyWord" => $this->domain->domain_host,
            "searchMode" => "EXACT",
            "status" => "Enable"
        ]);
        $runtime = new RuntimeOptions([]);
        try {
            // 复制代码运行请自行打印 API 的返回值
            $list = $this->client->describeDomainRecordsWithOptions($describeDomainRecordsRequest, $runtime);
            if(is_array($list->body->domainRecords->record)){
                $rec = $list->body->domainRecords->record[0];
                return new SimpleDnsRecord($rec->recordId,$rec->value);
            }else{
                return null;
            }
        }
        catch (Exception $error) {
            report($error);
            return null;
        }
    }
    public function update(SimpleDnsRecord $record):void
    {
        $updateDomainRecordRequest = new UpdateDomainRecordRequest();
        $updateDomainRecordRequest->RR=$this->domain->domain_host;
        $updateDomainRecordRequest->recordId=$record->id;
        $updateDomainRecordRequest->value=$record->ip;
        $updateDomainRecordRequest->type="A";
        $runtime = new RuntimeOptions([]);
        $this->client->updateDomainRecordWithOptions($updateDomainRecordRequest, $runtime);
    }

    public function create(string $ip): void
    {
        $addDomainRecordRequest = new AddDomainRecordRequest();
        $addDomainRecordRequest->type="A";
        $addDomainRecordRequest->RR=$this->domain->domain_host;
        $addDomainRecordRequest->domainName=$this->domain->domain_base;
        $addDomainRecordRequest->value=$ip;

        $runtime = new RuntimeOptions([]);
        $this->client->addDomainRecordWithOptions($addDomainRecordRequest, $runtime);
    }
}
