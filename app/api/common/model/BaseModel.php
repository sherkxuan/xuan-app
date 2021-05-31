<?php
declare (strict_types = 1);

namespace app\api\common\model;


use app\api\model\Label;
use app\api\model\Topic;
use app\api\model\Login;
use app\api\model\User;

/**
 * Trait BaseModel
 * @package app\api\common\model
 */
trait BaseModel
{
    public object $userModel;
    public object $loginModel;
    public object $topicModel;
    public object $labelModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->loginModel = new Login();
        $this->topicModel = new Topic();
        $this->labelModel = new Label();
    }
}
