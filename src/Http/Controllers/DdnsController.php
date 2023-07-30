<?php

namespace itinysun\ddns\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use itinysun\ddns\Models\DdnsDomain;
use Illuminate\Http\Request;
use itinysun\ddns\Lib\DdnsServerFactory;

class DdnsController extends Controller
{
    public function run($token, Request $request): string
    {
        if (empty($token))
            return 'bad';

        $ip = $this->getIp($request);
        if (empty($ip)){
            Log::error('[DDNS] error to get client ip');
            return 'bad';
        }


        try {
            $domain = DdnsDomain::query()->where('token', $token)->firstOrFail();
            $server = DdnsServerFactory::getServer($domain);
            $record = $server->find();
            if ($record) {
                if ($record->ip != $ip) {
                    $record->ip = $ip;
                    $server->update($record);
                }
            } else {
                $server->create($ip);
            }
            return 'good';
        } catch (\Throwable $e) {
            report($e);
            Log::error('[DDNS] error to run ddns update',['exception'=>$e->getMessage()]);
            return 'bad';
        }
    }

    protected function getIp(Request $request): string|null
    {
        return $request->query('ip') ?? $request->getClientIp();
    }
}
