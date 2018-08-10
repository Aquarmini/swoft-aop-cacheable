<?php
/**
 * Swoft Entity Cache
 *
 * @author   limx <limingxin@swoft.org>
 * @link     https://github.com/limingxinleo/swoft-aop-cacheable
 */
namespace Swoftx\Aop\Cacheable;

use Swoft\App;
use Swoft\Redis\Redis;
use Swoftx\Aop\Cacheable\Annotation\Cacheable;
use Swoftx\Aop\Cacheable\Collector\CacheableCollector;
use Swoftx\Aop\Cacheable\Collector\ListenerCollector;

class CacheHelper
{
    /**
     * 解析缓存KEY
     * @author limx
     * @param       $key
     * @param array $args
     * @return mixed
     */
    public static function parseKey($key, $args = [])
    {
        return preg_replace_callback('/\{(\d)\}/', function ($matches) use ($args) {
            $key = $matches[1];
            return $args[$key] ?? '';
        }, $key);
    }

    /**
     * 删除缓存
     * @author limx
     * @param string $listener
     * @param array  $args
     * @return bool
     */
    public static function deleteCache(string $listener, $args = []): bool
    {
        $collector = ListenerCollector::getListeners($listener);
        foreach ($collector as $item) {
            $className = $item['className'];
            $methodName = $item['methodName'];
            $annotation = CacheableCollector::getAnnotation($className, $methodName);
            $redis = bean(Redis::class);

            // 删除对应缓存
            if ($annotation && $annotation instanceof Cacheable) {
                $key = $annotation->getKey();
                $redisKey = static::parseKey($key, $args);
                $redis->delete($redisKey);
            }
        }

        return true;
    }

    /**
     * 重置缓存
     * @author limx
     * @param string $listener
     * @param array  $args
     * @return bool
     */
    public static function reloadCache(string $listener, $args = []): bool
    {
        $collector = ListenerCollector::getListeners($listener);
        foreach ($collector as $item) {
            $beanName = $item['beanName'];
            $className = $item['className'];
            $methodName = $item['methodName'];
            $annotation = CacheableCollector::getAnnotation($className, $methodName);
            $redis = bean(Redis::class);
            $deleted = false;

            // 删除对应缓存
            if ($annotation && $annotation instanceof Cacheable) {
                $key = $annotation->getKey();
                $redisKey = static::parseKey($key, $args);
                $deleted = $redis->delete($redisKey);
            }

            // 重置对应缓存
            if (App::hasBean($beanName) && $deleted) {
                $bean = bean($beanName);
                $bean->$methodName(...$args);
            }
        }

        return true;
    }
}
