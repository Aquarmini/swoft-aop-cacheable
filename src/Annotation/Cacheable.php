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
class Cacheable
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var int
     */
    protected $version = 0;

    /**
     * @var int;
     */
    protected $ttl = 3600;

    /**
     * @var bool
     */
    protected $reload = false;

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
        if (isset($values['version'])) {
            $this->version = $values['version'];
        }
        if (isset($values['ttl'])) {
            $this->ttl = $values['ttl'];
        }
        if (isset($values['reload'])) {
            $this->reload = $values['reload'];
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
     * @return int
     */
    public function getVersion(): int
    {
        return $this->version;
    }

    /**
     * @return int
     */
    public function getTtl(): int
    {
        // 增加0到600秒随机偏移量
        return $this->ttl + rand(0, 600);
    }

    /**
     * @return bool
     */
    public function isReload(): bool
    {
        return $this->reload;
    }
}
