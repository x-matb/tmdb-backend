<?php


class RedisCache implements CacheServiceInterface
{
    protected static $self;
    private $redis;

    # Removing protected for testing purposes
    public function __construct($url)
    {
        $this->redis = new Predis\Client($url);
    }

    public static function getInstance()
    {
        if (empty(static::$self)) {
            static::$self = new RedisCache(getenv('REDIS_URL'));
        }
        return static::$self;
    }

    function set($key, $value) {
        $data = $this->redis->set($key, json_encode($value));
        $this->redis->expire($key, 3600);
        return $data;
    }

    function get($key) {
        $data = $this->redis->get($key);
        if (is_null($data)) {
            return;
        }
        return json_decode($data);
    }

    function flush() {
        $this->redis->flushall();
    }
}