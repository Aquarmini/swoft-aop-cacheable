<?php
/**
 * Swoft Entity Cache
 *
 * @author   limx <limingxin@swoft.org>
 * @link     https://github.com/limingxinleo/swoft-aop-cacheable
 */
namespace Swoftx\Aop\Cacheable;

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
        return true;
    }
}
