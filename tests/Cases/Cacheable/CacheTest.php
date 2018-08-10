<?php
/**
 * Swoft Entity Cache
 *
 * @author   limx <limingxin@swoft.org>
 * @link     https://github.com/limingxinleo/swoft-aop-cacheable
 */

namespace SwoftTest\Cases\Cacheable;

use Swoft\Redis\Redis;
use SwoftTest\Cases\AbstractCacheCase;
use SwoftTest\Testing\Bean\Demo;
use SwoftTest\Testing\Constant;
use Swoftx\Aop\Cacheable\CacheHelper;
use Swoftx\Aop\Cacheable\Collector\ListenerCollector;

class CacheTest extends AbstractCacheCase
{
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testCacheable()
    {
        $bean = bean(Demo::class);
        $res1 = $bean->output('limx');
        $res2 = $bean->output('limx');

        $this->assertEquals($res1, $res2);

        $res3 = $bean->output('Agnes');
        $this->assertNotEquals($res1, $res3);

        $redis = bean(Redis::class);
        $this->assertEquals(1, $redis->exists('output:limx::'));

        $redis->delete('output:limx::');
        $res4 = $bean->output('limx');
        $this->assertNotEquals($res1, $res4);
    }

    public function testCacheableByCo()
    {
        go(function () {
            $this->testCacheable();
        });
    }

    public function testCacheableVersion()
    {
        $bean = bean(Demo::class);
        $res1 = $bean->output('limx2');
        $res2 = $bean->output2('limx2');

        $this->assertNotEquals($res1, $res2);

        $res3 = $bean->output('limx2');
        $this->assertNotEquals($res1, $res3);
    }

    public function testCacheableVersionByCo()
    {
        go(function () {
            $this->testCacheableVersion();
        });
    }

    public function testCacheableReload()
    {
        $bean = bean(Demo::class);
        $res1 = $bean->output('limx3');
        $res2 = $bean->output('limx3');

        $this->assertEquals($res1, $res2);

        $res3 = $bean->output('Agnes3');
        $this->assertNotEquals($res1, $res3);

        $res4 = $bean->reloadOutput('limx3');
        $this->assertNotEquals($res1, $res4);

        $res5 = $bean->output('limx3');
        $this->assertEquals($res4, $res5);
    }

    public function testCacheableReloadByCo()
    {
        go(function () {
            $this->testCacheableReload();
        });
    }

    public function testListener()
    {
        $res = ListenerCollector::getCollector();
        $this->assertArrayHasKey(Constant::LISTENER_DEMO_OUTPUT, $res);

        $bean = bean(Demo::class);
        $res1 = $bean->output('limx4');
        $res2 = $bean->output('limx4');

        $this->assertEquals($res1, $res2);

        $bool = CacheHelper::deleteCache(Constant::LISTENER_DEMO_OUTPUT, ['limx4']);
        $this->assertTrue($bool);
        $redis = bean(Redis::class);
        $this->assertEquals(0, $redis->exists('output:limx4::'));

        $res3 = $bean->output('limx4');
        $this->assertNotEquals($res1, $res3);

        $obj1 = unserialize($redis->get('output:limx4::'));
        $res4 = $bean->output('limx4');
        $obj2 = unserialize($redis->get('output:limx4::'));

        $this->assertEquals($obj1, $obj2);

        $bool = CacheHelper::reloadCache(Constant::LISTENER_DEMO_OUTPUT, ['limx4']);
        $this->assertTrue($bool);

        $obj3 = unserialize($redis->get('output:limx4::'));
        $this->assertNotEquals($obj1, $obj3);
        $res5 = $bean->output('limx4');
        $this->assertNotEquals($res4, $res5);
    }

    public function testListenerByCo()
    {
        go(function () {
            $this->testListener();
        });
    }
}
