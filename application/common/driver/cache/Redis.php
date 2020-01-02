<?php

namespace app\common\driver\cache;

/**
 * Class Redis
 * @property \Redis $handler
 */
class Redis extends \think\cache\driver\Redis
{
    /**
     * 写入缓存
     * @param string $name 缓存变量名
     * @param mixed $value 存储数据
     * @param int|\DateTime $expire 有效时间（秒）
     * @return bool
     */
    public function set($name, $value, $expire = null)
    {
        if (is_null($expire)) {
            $expire = $this->options['expire'];
        }
        if ($expire instanceof \DateTime) {
            $expire = $expire->getTimestamp() - time();
        }
        if ($this->tag && !$this->has($name)) {
            $first = true;
        }
        $key = $this->getCacheKey($name);
        $value = serialize($value);
        if ($expire) {
            $result = $this->handler->setex($key, $expire, $value);
        } else {
            $result = $this->handler->set($key, $value);
        }
        isset($first) && $this->setTagItem($key);
        return $result;
    }

    /**
     * 读取缓存
     * @param string $name 缓存变量名
     * @param mixed $default 默认值
     * @return mixed
     */
    public function get($name, $default = false)
    {
        $value = $this->handler->get($this->getCacheKey($name));
        if (is_null($value) || false === $value) {
            return $default;
        }

        try {
            $result = unserialize($value);
        } catch (\Exception $e) {
            $result = $default;
        }

        return $result;
    }

    /**
     * 清除缓存
     * @param string $tag 标签名
     * @return bool
     */
    public function clear($tag = null)
    {
        if ($tag) {
            // 指定标签清除
            $keys = $this->getTagItem($tag);
            $this->handler->del($keys);
            $this->rm('tag_' . md5($tag));
            return true;
        }
        $keys = $this->handler->keys($this->getCacheKey('*'));
        return $this->handler->del($keys);
    }

    /**
     * 删除缓存
     * @param string $name 缓存变量名
     * @return bool
     */
    public function rm($name)
    {
        return $this->handler->del($this->getCacheKey($name));
    }
}
