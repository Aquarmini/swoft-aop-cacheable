# swoft-aop-cacheable
Swoft 基于Aop缓存

[![Build Status](https://travis-ci.org/limingxinleo/swoft-aop-cacheable.svg?branch=master)](https://travis-ci.org/limingxinleo/swoft-aop-cacheable)

## 使用
config/properties/app.php中增加对应beanScan
~~~
return [
    ...
    'beanScan' => require __DIR__ . DS . 'beanScan.php',
];

# beanScan.php 如下

$beanScan = [
    'App\\Breaker',
    'App\\Controllers',
    'App\\Core',
    'App\\Exception',
    'App\\Fallback',
    'App\\Lib',
    'App\\Listener',
    'App\\Middlewares',
    'App\\Models',
    'App\\Pool',
    'App\\Process',
    'App\\Services',
    'App\\Tasks',
    'App\\WebSocket',
];

$customBean = [
    'App\\Biz',
    'App\\Config',
    'App\\Jobs',
    'Swoftx\\Aop\\Cacheable\\',
];

$beanScan = array_merge($beanScan, $customBean, $entityCacheBean);
return $beanScan;
~~~

增加需要进入缓存切面的类
~~~php
<?php

namespace SwoftTest\Testing\Bean;

use Swoftx\Aop\Cacheable\Annotation\CacheBean;
use Swoft\Bean\Annotation\Bean;
use Swoftx\Aop\Cacheable\Annotation\Cacheable;

/**
 * Class Demo
 * @CacheBean
 * @Bean
 * @package SwoftTest\Testing\Bean
 */
class Demo
{
    /**
     *
     * @author limx
     * @Cacheable(key="output:{0}:{1}:{2}", ttl=36000)
     * @param $name
     * @return mixed
     */
    public function output($name, $sex = 1, $msg = 'hello world')
    {
        return $name;
    }
}
~~~

调用
~~~php
<?php
use SwoftTest\Testing\Bean\Demo;

$bean = bean(Demo::class);
$res = $bean->output('limx');
~~~
