<?php

return [
    // 默认磁盘
    'default' => env('filesystem.driver', 'local'),
    // 磁盘列表
    'disks'   => [
        'local'  => [
            'type' => 'local',
            'root' => app()->getRuntimePath() . 'storage',
        ],
        'public' => [
            // 磁盘类型
            'type'       => 'local',
            // 磁盘路径
            'root'       => app()->getRootPath() . 'public/storage',
            // 磁盘路径对应的外部URL路径
            'url'        => '/storage',
            // 可见性
            'visibility' => 'public',
        ],
        // 更多的磁盘配置信息
        'aliyun' => [
            'type'         => 'aliyun',
            'accessId'     => '******',
            'accessSecret' => '******',
            'bucket'       => 'bucket',
            'endpoint'     => 'oss-cn-hongkong.aliyuncs.com',
            'url'          => 'http://oss-cn-hongkong.aliyuncs.com',//不要斜杠结尾，此处为URL地址域名。
        ],
        'qiniu'  => [
            'type'      => 'qiniu',
            'accessKey' => env('qiniu.accessKey','******'),
            'secretKey' => env('qiniu.secretKey','******'),
            'bucket'    => env('qiniu.bucket','******'),
            'url'       => env('qiniu.url','******'),
        ],
        'qcloud' => [
            'type'       => 'qcloud',
            'region'      => '***', //bucket 所属区域 英文
            'appId'      => '***', // 域名中数字部分
            'secretId'   => '***',
            'secretKey'  => '***',
            'bucket'          => '***',
            'timeout'         => 60,
            'connect_timeout' => 60,
            'cdn'             => '您的 CDN 域名',
            'scheme'          => 'https',
            'read_from_cdn'   => false,
        ]
    ],
];
