<?php
/**
 * Swoft Entity Cache
 *
 * @author   limx <limingxin@swoft.org>
 * @link     https://github.com/limingxinleo/swoft-aop-cacheable
 */
namespace Swoftx\Aop\Cacheable\Collector;

use Swoft\Bean\CollectorInterface;
use Swoftx\Aop\Cacheable\Annotation\Listener;

class ListenerCollector implements CollectorInterface
{
    protected static $listeners = [];

    public static function collect(
        string $className,
        $objectAnnotation = null,
        string $propertyName = '',
        string $methodName = '',
        $propertyValue = null
    ) {
        if (($objectAnnotation instanceof Listener) && $name = $objectAnnotation->getName()) {
            $beanName = $objectAnnotation->getBeanName() ?? $className;
            static::$listeners[$name][] = [
                'beanName' => $beanName,
                'methodName' => $methodName,
                'objectAnnotation' => $objectAnnotation,
                'propertyValue' => $propertyValue,
            ];
        }
    }

    public static function getCollector()
    {
        return static::$listeners;
    }

    public static function getListeners($listener)
    {
        return static::$listeners[$listener] ?? [];
    }
}
