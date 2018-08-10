<?php
/**
 * Swoft Entity Cache
 *
 * @author   limx <limingxin@swoft.org>
 * @link     https://github.com/limingxinleo/swoft-aop-cacheable
 */
namespace Swoftx\Aop\Cacheable;

use Swoftx\Aop\Cacheable\Annotation\Cacheable;

class CacheObject
{
    /**
     * @var Cacheable
     */
    protected $annotation;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * CacheObject constructor.
     * @param Cacheable $annotation
     * @param mixed     $data
     */
    public function __construct(Cacheable $annotation, $data)
    {
        $this->annotation = $annotation;
        $this->data = $data;
    }

    /**
     * @return Cacheable
     */
    public function getAnnotation(): Cacheable
    {
        return $this->annotation;
    }

    /**
     * @param Cacheable $annotation
     */
    public function setAnnotation(Cacheable $annotation)
    {
        $this->annotation = $annotation;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}
