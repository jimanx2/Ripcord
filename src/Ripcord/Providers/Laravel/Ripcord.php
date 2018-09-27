<?php

namespace Ripcord\Providers\Laravel;

use Ripcord\Ripcord as RipcordBase;

class Ripcord
{
    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $db;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var string
     */
    protected $password;
    /**
     * @var int
     */
    public $uid;

    /**
     * @var \Ripcord\Client\Client
     */
    public $client;

    /**
     * Ripcord constructor.
     *
     * @param $config array
     */
    public function __construct($config = [])
    {
        $this->url = isset($config['url']) ? $config['url'] : config('ripcord.url');
        $this->db = isset($config['db']) ? $config['db'] : config('ripcord.db');
        $this->username = isset($config['user']) ? $config['user'] : config('ripcord.user');
        $this->password = isset($config['password']) ? $config['password'] : config('ripcord.password');

        $this->connect();
    }

    /**
     * Create connection.
     */
    public function connect()
    {
        $common = RipcordBase::client("$this->url/common");
        $this->uid = $common->authenticate($this->db, $this->username, $this->password, []);
        $this->client = RipcordBase::client("$this->url/object");
    }

    public function execute_kw($object, $method, $clause, $options)
    {
        return $this->client->execute_kw($this->db, $this->uid, $this->password, $object, $method, $clause, $options);
    }
}
