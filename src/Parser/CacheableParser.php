<?php
/**
 * Swoft Entity Cache
 *
 * @author   limx <limingxin@swoft.org>
 * @link     https://github.com/limingxinleo/swoft-aop-cacheable
 */
namespace Swoftx\Aop\Cacheable\Parser;

use Swoft\Bean\Collector;
use Swoft\Bean\Parser\AbstractParser;
use Swoftx\Aop\Cacheable\Collector\CacheableCollector;

class CacheableParser extends AbstractParser
{
    public function parser(
        string $className,
        $objectAnnotation = null,
        string $propertyName = '',
        string $methodName = '',
        $propertyValue = null
    ) {
        Collector::$methodAnnotations[$className][$methodName][] = get_class($objectAnnotation);
        CacheableCollector::collect($className, $objectAnnotation, $propertyName, $methodName, $propertyValue);
        return null;
    }
}
