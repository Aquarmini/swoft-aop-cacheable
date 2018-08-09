# swoft-aop-cacheable
Swoft 基于Aop缓存

[![Build Status](https://travis-ci.org/limingxinleo/swoft-aop-cacheable.svg?branch=master)](https://travis-ci.org/limingxinleo/swoft-aop-cacheable)

## 使用
config/properties/app.php中增加对应的组件
~~~
'components' => [
    'custom' => [
        'Swoftx\\Aop\\Cacheable\\',
    ],
]
~~~

增加需要进入缓存切面的类
~~~php
<?php

namespace SwoftTest\Testing\Bean;

use Swoft\Bean\Annotation\Bean;
use Swoftx\Aop\Cacheable\Annotation\Cacheable;

/**
 * Class Demo
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
