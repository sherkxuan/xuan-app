<?php
declare (strict_types = 1);

namespace app\api\model;

use think\Model;
use think\model\concern\SoftDelete;
use think\model\relation\HasOne;

/**
 * @mixin Model
 */
class User extends Model
{
    use SoftDelete;
    protected string $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;
    protected $type = [
        'birthday'  => 'timestamp:Y-m-d'
    ];
    // 定义全局的查询范围
    protected function base($query)
    {
        $query->where('status',1);
    }
    public function login(): HasOne
    {
        return $this->hasOne('login','user_id','id');
    }
    public function getSexAttr($value): string
    {
        $status = ['保密','男','女'];
        return $status[$value];
    }
}
