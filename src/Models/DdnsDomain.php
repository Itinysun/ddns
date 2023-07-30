<?php
namespace itinysun\ddns\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Slowlyo\OwlAdmin\Models\BaseModel as Model;

/**
 * 域名列表
 *
 * @property int $id
 * @property string $cloud 云厂商
 * @property string $appid
 * @property string $secret
 * @property string $domain_base 根域名
 * @property string $domain_host
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property string $token
 * @method static Builder|DdnsDomain newModelQuery()
 * @method static Builder|DdnsDomain newQuery()
 * @method static Builder|DdnsDomain onlyTrashed()
 * @method static Builder|DdnsDomain query()
 * @method static Builder|DdnsDomain whereAppid($value)
 * @method static Builder|DdnsDomain whereCloud($value)
 * @method static Builder|DdnsDomain whereCreatedAt($value)
 * @method static Builder|DdnsDomain whereDeletedAt($value)
 * @method static Builder|DdnsDomain whereDomainBase($value)
 * @method static Builder|DdnsDomain whereDomainHost($value)
 * @method static Builder|DdnsDomain whereId($value)
 * @method static Builder|DdnsDomain whereSecret($value)
 * @method static Builder|DdnsDomain whereToken($value)
 * @method static Builder|DdnsDomain whereUpdatedAt($value)
 * @method static Builder|DdnsDomain whereUserId($value)
 * @method static Builder|DdnsDomain withTrashed()
 * @method static Builder|DdnsDomain withoutTrashed()
 * @mixin Eloquent
 */
class DdnsDomain extends Model
{
    use SoftDeletes;
    protected $hidden=['appid','secret'];
}
