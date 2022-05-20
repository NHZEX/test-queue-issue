<?php

use Imi\Queue\Driver\RedisQueueDriver;

$rootPath = dirname(__DIR__).'/';

return [
    'hotUpdate'    =>    [
        // 'status'    =>    false, // 关闭热更新去除注释，不设置即为开启，建议生产环境关闭

        // --- 文件修改时间监控 ---
        // 'monitorClass'    =>    \Imi\HotUpdate\Monitor\FileMTime::class,
        'timespan'    =>    1, // 检测时间间隔，单位：秒

        // --- Inotify 扩展监控 ---
        'monitorClass'    =>    extension_loaded('inotify') ? \Imi\HotUpdate\Monitor\Inotify::class : \Imi\HotUpdate\Monitor\FileMTime::class,
        // 'timespan'    =>    1, // 检测时间间隔，单位：秒，使用扩展建议设为0性能更佳

        // 'includePaths'    =>    [], // 要包含的路径数组
        'excludePaths'    =>    [
            $rootPath.'.git',
            $rootPath.'.idea',
            $rootPath.'.vscode',
            $rootPath.'vendor',
        ], // 要排除的路径数组，支持通配符*
    ],
    'AutoRunProcessManager' => [
        'processes' => [
            'TestProcess',
            'QueueConsumer',
        ],
    ],
    'imiQueue'  =>  [
        // 默认队列
        'default'   =>  'test',
        // 队列列表
        'list'  =>  [
            'test123' =>  [
                // 使用的队列驱动
                'driver'        =>  RedisQueueDriver::class,
                // 消费协程数量
                'co'            =>  4,
                // 消费进程数量；可能会受进程分组影响，以同一组中配置的最多进程数量为准
                'process'       =>  1,
                // 消费循环尝试 pop 的时间间隔，单位：秒
                'timespan'      =>  1,
                // 进程分组名称
                'processGroup'  =>  'co:test1',
                // 自动消费
                'autoConsumer'  =>  true,
                // 消费者类
                'consumer'      =>  'TestConsumer',
                // 驱动类所需要的参数数组
                'config'        =>  [
                    'poolName'  =>  'redis_queue',
                    'prefix'    =>  'imi:queue:test123:',
                ]
            ],
            'test' =>  [
                // 使用的队列驱动
                'driver'        =>  RedisQueueDriver::class,
                // 消费协程数量
                'co'            =>  1,
                // 消费进程数量；可能会受进程分组影响，以同一组中配置的最多进程数量为准
                'process'       =>  1,
                // 消费循环尝试 pop 的时间间隔，单位：秒
                'timespan'      =>  1,
                // 进程分组名称
                'processGroup'  =>  'co:test',
                // 自动消费
                'autoConsumer'  =>  true,
                // 消费者类
                'consumer'      =>  'TestConsumer',
                // 驱动类所需要的参数数组
                'config'        =>  [
                    'poolName'  =>  'redis_queue',
                    'prefix'    =>  'imi:queue:test:',
                ]
            ],
        ],
    ],
];
