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
        $res = $bean->output('limx');

        $this->assertEquals('limx', $res);

        $redis = bean(Redis::class);
        $this->assertEquals(1, $redis->exists('output:limx::'));
    }
}
