<?php

namespace itinysun\ddns\Services;

use itinysun\ddns\Models\DdnsDomain;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Slowlyo\OwlAdmin\Admin;
use Slowlyo\OwlAdmin\Services\AdminService;

/**
 * 域名列表
 *
 * @method DdnsDomain getModel()
 */
class DomainService extends AdminService
{
    protected string $modelName = DdnsDomain::class;

    public function query(): Builder
    {
        $q = parent::query();
        if(!Admin::user()->isAdministrator()){
            return $q->where('user_id',Admin::user()->id);
        }else{
            return $q;
        }
    }
    public function getDetail($id): DdnsDomain
    {
        /* @var DdnsDomain $dt */
        $dt = $this->query()->find($id);
        $dt->token = route('ddns.run',$dt->token);
        $dt->appid = Str::mask($dt->appid,'*',3,-3);
        $dt->secret = Str::mask($dt->secret,'*',3,-3);
        $dt->makeVisible('appid','secret');
        return $dt;
    }

    public function getEditData($id): Model|Collection|Builder|array|null
    {
        $model = $this->getModel();
        $dt = $this->query()->find($id);
        $dt->appid = Str::mask($dt->appid,'*',3,-3);
        $dt->secret = Str::mask($dt->secret,'*',3,-3);
        $dt->makeVisible('appid','secret');
        return $dt->makeHidden([$model->getCreatedAtColumn(), $model->getUpdatedAtColumn()]);
    }

}
