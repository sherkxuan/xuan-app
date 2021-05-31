<?php
declare (strict_types = 1);

namespace app\api\model;

use think\Model;
use think\model\concern\SoftDelete;

/**
 * @mixin Model
 */
class Topic extends Model
{
    use SoftDelete;
    protected string $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0;
    //
}
