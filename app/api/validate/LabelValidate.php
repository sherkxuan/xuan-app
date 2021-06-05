<?php
declare (strict_types = 1);

namespace app\api\validate;

class LabelValidate extends BaseValidate
{
    /**
     * 定义验证规则
     * 格式：'字段名' =>  ['规则1','规则2'...]
     *
     * @var array
     */
    protected $rule = [
        'name'  =>  'require|checkName',
    ];

    /**
     * 定义错误信息
     * 格式：'字段名.规则名' =>  '错误信息'
     *
     * @var array
     */
    protected $message = [];

    protected $scene = [
        'create'    =>  ['name']
    ];
    // 自定义验证规则
    protected function checkName($value)
    {
        if(!is_array($value)){
            $num = mb_strlen($value);
            if($num<2 || $num>10){
                return '标签长度必须是2-10个字';
            }else{
                return true;
            }
        }
        array_map(function ($item){
            $num = mb_strlen($item);
            if($num<2 || $num>10){
                throw new VerifyException('单个标签长度必须是2-10个字',204);
            }else{
                return $item;
            }
        },$value);
        return true;
    }
}
