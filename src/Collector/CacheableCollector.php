<?php
/**
 * Swoft Entity Cache
 *
 * @author   limx <limingxin@swoft.org>
 * @link     https://github.com/limingxinleo/swoft-aop-cacheable
 */
namespace Swoftx\Aop\Cacheable\Collector;

use Swoft\Bean\CollectorInterface;

class CacheableCollector implements CollectorInterface
{
    protected static $annotations = [];

    public static function collect(
        string $className,
        $objectAnnotation = null,
        string $propertyName = '',
        string $methodName = '',
        $propertyValue = null
    ) {
        static::$annotations[$className][$methodName] = $objectAnnotation;
    }

    public static function getCollector()
    {
        return static::$annotations;
    }

    /**
     * 获取对应注解
     * @author limx
     * @param $className
     * @param $methodName
     * @return null
     */
    public static function getAnnotation($className, $methodName)
    {
        $annotations = static::getCollector();
        if (isset($annotations[$className][$methodName])) {
            return $annotations[$className][$methodName];
        }
        return null;
    }
}
