<?php

namespace itinysun\ddns\Lib;

use itinysun\ddns\Models\DdnsDomain;
use TencentCloud\Common\Credential;
use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;
use TencentCloud\Dnspod\V20210323\DnspodClient;
use TencentCloud\Dnspod\V20210323\Models\CreateRecordRequest;
use TencentCloud\Dnspod\V20210323\Models\DescribeRecordListRequest;
use TencentCloud\Dnspod\V20210323\Models\ModifyRecordRequest;
use TencentCloud\Dnspod\V20210323\Models\RecordListItem;

class QcloudDns implements DdnsServerInterface
{
    protected DdnsDomain $domain;
    protected DnspodClient $client;

    public function __construct(DdnsDomain $domain)
    {
        $this->domain = $domain;
        $cred = new Credential($domain->appid, $domain->secret);
        // 实例化一个http选项，可选的，没有特殊需求可以跳过
        $httpProfile = new HttpProfile();
        $httpProfile->setEndpoint("dnspod.tencentcloudapi.com");

        // 实例化一个client选项，可选的，没有特殊需求可以跳过
        $clientProfile = new ClientProfile();
        $clientProfile->setHttpProfile($httpProfile);
        // 实例化要请求产品的client对象,clientProfile是可选的
        $this->client = new DnspodClient($cred, "", $clientProfile);
    }

    /**
     * @throws TencentCloudSDKException
     */
    public function find(): ?SimpleDnsRecord
    {
        $req = new DescribeRecordListRequest();

        $params = array(
            "Domain" => $this->domain->domain_base,
            "Subdomain" => $this->domain->domain_host
        );
        $req->fromJsonString(json_encode($params));

        // 返回的resp是一个DescribeRecordListResponse的实例，与请求对象对应
        try {
            $resp = $this->client->DescribeRecordList($req);
            /* @var RecordListItem $rec */
            $rec = $resp->RecordList[0];
            return new SimpleDnsRecord($rec->RecordId,$rec->Value);
        } catch (TencentCloudSDKException $e) {
            if ($e->getErrorCode() == 'ResourceNotFound.NoDataOfRecord') {
                return null;
            } else {
                throw $e;
            }
        }
    }

    public function update(SimpleDnsRecord $record)
    {
        $req = new ModifyRecordRequest();
        $req->Value = $record->ip;
        $req->RecordId = $record->id;
        $req->RecordType = "A";
        $req->SubDomain = $this->domain->domain_host;
        $req->RecordLine = "默认";
        $req->Domain = $this->domain->domain_base;

        // 返回的resp是一个ModifyRecordResponse的实例，与请求对象对应
        $resp = $this->client->ModifyRecord($req);
    }

    public function create(string $ip)
    {
        $req = new CreateRecordRequest();
        $req->Value = $ip;
        $req->RecordType = "A";
        $req->SubDomain = $this->domain->domain_host;
        $req->Domain = $this->domain->domain_base;
        $req->RecordLine = "默认";
        $resp = $this->client->CreateRecord($req);
        return true;
    }
}
