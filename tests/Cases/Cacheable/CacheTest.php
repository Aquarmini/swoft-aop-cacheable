<?php
/**
 * Swoft Entity Cache
 *
 * @author   limx <715557344@qq.com>
 * @link     https://github.com/limingxinleo/swoft-aop-cacheable
 */

namespace SwoftTest\Cases\Cacheable;

use Swoft\Redis\Redis;
use SwoftTest\Cases\AbstractMysqlCase;
use SwoftTest\Testing\Bean\Demo;

class CacheTest extends AbstractMysqlCase
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

    public function testCacheableVersion()
    {
        $bean = bean(Demo::class);
        $res1 = $bean->output('limx');
        $res2 = $bean->output2('limx');

        $this->assertNotEquals($res1, $res2);

        $res3 = $bean->output('limx');
        $this->assertNotEquals($res1, $res3);
    }

    public function testCacheableReload()
    {
        $bean = bean(Demo::class);
        $res1 = $bean->output('limx');
        $res2 = $bean->output('limx');

        $this->assertEquals($res1, $res2);

        $res3 = $bean->output('Agnes');
        $this->assertNotEquals($res1, $res3);

        $res4 = $bean->reloadOutput('limx');
        $this->assertNotEquals($res1, $res4);

        $res5 = $bean->output('limx');
        $this->assertEquals($res4, $res5);
    }
}
