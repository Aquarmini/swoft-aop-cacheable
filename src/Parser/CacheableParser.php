<?php
/**
 * Swoft Entity Cache
 *
 * @author   limx <715557344@qq.com>
 * @link     https://github.com/limingxinleo/swoft-aop-cacheable
 */
namespace Swoftx\Aop\Cacheable\Parser;

use Swoft\Bean\Collector;
use Swoft\Bean\Parser\AbstractParser;

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
        return null;
    }
}
