<?php
/**
 * Swoft Entity Cache
 *
 * @author   limx <limingxin@swoft.org>
 * @link     https://github.com/limingxinleo/swoft-aop-cacheable
 */
namespace Swoftx\Aop\Cacheable;

use Swoft\Aop\ProceedingJoinPoint;
use Swoft\Bean\Annotation\Aspect;
use Swoft\Bean\Annotation\PointAnnotation;
use Swoft\Redis\Redis;
use Swoftx\Aop\Cacheable\Annotation\Cacheable;
use Swoft\Bean\Annotation\Around;
use Swoftx\Aop\Cacheable\Collector\CacheableCollector;

/**
 * Class CacheableAspect
 * @Aspect
 * @PointAnnotation(
 *     include={
 *         Cacheable::class
 *     }
 * )
 * @package Swoftx\Aop\Cacheable
 */
class CacheableAspect
{
    /**
     * @Around
     */
    public function around(ProceedingJoinPoint $proceedingJoinPoint)
    {
        $class = $proceedingJoinPoint->getTarget();
        $method = $proceedingJoinPoint->getMethod();

        /** @var Cacheable $annotation */
        $annotation = CacheableCollector::getAnnotation(get_class($class), $method);
        if (!$annotation) {
            // 从方法中获取结果
            return $proceedingJoinPoint->proceed();
        }

        $redis = bean(Redis::class);
        $key = $annotation->getKey();
        $args = $proceedingJoinPoint->getArgs();
        $key = CacheHelper::parseKey($key, $args);

        // 缓存命中且不需要Reload时，直接取数据
        if ($redis->exists($key) && $annotation->isReload() === false) {
            $cache = unserialize($redis->get($key));
            if ($cache instanceof CacheObject) {
                if ($cache->getAnnotation()->getVersion() === $annotation->getVersion()) {
                    // 当缓存版本与设置的版本一致时，返回对应数据
                    return $cache->getData();
                }
            }
        }

        $result = $proceedingJoinPoint->proceed();
        $ttl = $annotation->getTtl();
        $cache = new CacheObject($annotation, $result);
        $redis->set($key, serialize($cache), $ttl);

        return $result;
    }
}
