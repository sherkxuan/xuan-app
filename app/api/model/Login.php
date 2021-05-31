<?php
declare (strict_types = 1);

namespace app\api\model;

use think\Model;
use think\model\concern\SoftDelete;
use think\model\relation\BelongsTo;

/**
 * @mixin Model
 */
class Login extends Model
{
    use SoftDelete;
    protected string $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;
    public function user(): BelongsTo
    {
        return $this->belongsTo('user','user_id','id');
    }
}
