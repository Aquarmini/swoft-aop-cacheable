<?php
/**
 * Swoft Entity Cache
 *
 * @author   limx <limingxin@swoft.org>
 * @link     https://github.com/limingxinleo/swoft-aop-cacheable
 */
namespace Swoftx\Aop\Cacheable\Annotation;

/**
 * Class Cacheable
 * @Annotation
 * @Target("METHOD")
 * @package Swoftx\Aop\Cacheable\Annotation
 */
class Listener
{
    /**
     * 监听器名
     * @var string
     */
    protected $name;

    /**
     * Bean名
     * @var string
     */
    protected $beanName;

    /**
     * 缓存KEY
     * @var string
     */
    protected $key;

    /**
     * Cacheable constructor.
     *
     * @param array $values
     */
    public function __construct(array $values)
    {
        if (isset($values['value'])) {
            $this->name = $values['value'];
        }
        if (isset($values['name'])) {
            $this->name = $values['name'];
        }
        if (isset($values['key'])) {
            $this->key = $values['key'];
        }
        if (isset($values['beanName'])) {
            $this->beanName = $values['beanName'];
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getBeanName()
    {
        return $this->beanName;
    }
}
