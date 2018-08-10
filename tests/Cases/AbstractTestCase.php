<?php
/**
 * Swoft Entity Cache
 *
 * @author   limx <limingxin@swoft.org>
 * @link     https://github.com/limingxinleo/swoft-aop-cacheable
 */
namespace SwoftTest\Cases;

use PHPUnit\Framework\TestCase;

/**
 * Class AbstractTestCase
 *
 * @package SwoftTest\Db\Cases
 */
abstract class AbstractTestCase extends TestCase
{
    protected function tearDown()
    {
        parent::tearDown();
        swoole_timer_after(6 * 1000, function () {
            swoole_event_exit();
        });
    }
}
