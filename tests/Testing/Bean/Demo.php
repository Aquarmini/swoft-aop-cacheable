<?php
/**
 * Swoft Entity Cache
 *
 * @author   limx <715557344@qq.com>
 * @link     https://github.com/limingxinleo/swoft-aop-cacheable
 */
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
