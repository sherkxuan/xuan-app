<?php

namespace app\admin\controller;

use app\api\common\model\BaseModel;
use app\BaseController;
use Curl\Curl;
use think\db\exception\{DataNotFoundException,DbException,ModelNotFoundException};
use Exception;
use think\facade\Log;
use think\response\Json;

class Index extends BaseController
{
    use BaseModel;

    /**
     * @return Json
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @throws Exception
     */
    public function getLabel(): Json
    {
        //随机用户id
        $ids = $this->userModel->field('id')->orderRand()->where('is_robot',1)->limit(20)->select();
        //随机标签
        $path = public_path().'storage/ci.json';
        $content = file_get_contents($path);
        $labelData = json_decode($content,true);
        $m=memory_get_usage();
        $data = [];
        foreach ($ids as $v){
            //获取随机标签
            $label = $this->getLabelRand($labelData);

            $data[] = [
                'user_id'=>$v['id'],
                'name'  => $label
            ];
        }
        $res = $this->labelModel->saveAll($data);
        return $this->success(array_column($res->toArray(),'name'));
    }

    /**
     * @throws ModelNotFoundException
     * @throws DbException
     * @throws DataNotFoundException
     */
    public function getLabelRand($labelData){
        //创建随机标签
        $randLabel = $labelData[array_rand($labelData)];
        //查询是否有重复标签
        $find = $this->labelModel->where('name',$randLabel['ci'])->find();
        if($find){
            $this->getLabelRand($labelData);
        }else{
            return $randLabel['ci'];
        }
        return false;
    }
    public function index(): Json
    {
        $path = public_path().'storage/ci.json';
//        dd($path);
        $content = file_get_contents($path);
//        print_r($content);
        $data = json_decode($content,true);
        //dd(count($data));
        $k = array_rand($data);
        return json($data[$k]);
//        return json($content);
        //return $this->success('你成功的访问到了主页,访问时间:'.Date('Y-m-d H:i:s',time()));
    }

    public function head()
    {
        /**
         * 请求地址：http://api.btstu.cn/sjtx/api.php
         *
         * 请求参数：
         * method 输出壁纸端[mobile(手机端),pc（电脑端）,zsy（手机电脑自动判断）]默认为pc
         * lx 输出头像类型[a1（男头）|b1（女头）|c1（动漫头像）|c2（动漫女头）|c3（动漫男头）]默认为c1
         * format 输出壁纸格式[json|images]默认为images
         *
         * 返回参数
         * code	string	返回的状态码
         * imul	string	返回图片地址
         * width	string	返回图片宽度
         * height	string	返回图片高度
         *
         */
        $sex =1;
        $curl = new Curl();
        $arr = [
            'lx'=>$sex==1?'a1':'b1'
        ];
        $curl->setOpt(CURLOPT_FOLLOWLOCATION,true);
        $curl->get('http://api.btstu.cn/sjtx/api.php',$arr);
        $url = curl_getinfo($curl->curl,CURLINFO_EFFECTIVE_URL);

        $curl->close();
        if($curl->http_status_code==200){
            return $url;
        }else{
            Log::alert('头像生成出错:'.$curl->error_message);
            return "https://tva2.sinaimg.cn/large/9bd9b167ly1fzjwj3mxqqj20b40b4t95.jpg";
        }
    }
}
