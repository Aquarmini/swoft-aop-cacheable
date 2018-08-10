<?php
/**
 * Swoft Entity Cache
 *
 * @author   limx <limingxin@swoft.org>
 * @link     https://github.com/limingxinleo/swoft-aop-cacheable
 */
namespace SwoftTest\Testing\Bean;

use Swoft\Bean\Annotation\Bean;
use Swoftx\Aop\Cacheable\Annotation\Cacheable;
use Swoftx\Aop\Cacheable\Annotation\Listener;
use SwoftTest\Testing\Constant;

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
     * @Listener(Constant::LISTENER_DEMO_OUTPUT)
     * @param $name
     * @return mixed
     */
    public function output($name, $sex = 1, $msg = 'hello world')
    {
        return $this->rand();
    }

    /**
     *
     * @author limx
     * @Cacheable(key="output:{0}:{1}:{2}", ttl=36000, reload=true)
     * @param $name
     * @return mixed
     */
    public function reloadOutput($name, $sex = 1, $msg = 'hello world')
    {
        return $this->output($name, $sex, $msg);
    }

    /**
     *
     * @author limx
     * @Cacheable(key="output:{0}:{1}:{2}", ttl=36000, version=1)
     * @param $name
     * @return mixed
     */
    public function output2($name, $sex = 1, $msg = 'hello world')
    {
        return $this->rand();
    }

    public function rand()
    {
        return rand(0, 9999);
    }
}
