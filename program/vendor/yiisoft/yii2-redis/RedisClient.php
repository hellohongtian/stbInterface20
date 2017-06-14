<?php
/**
 * 刘琛：使用phpredis扩展来进行redis命令调用，具体的api介绍可以参考以下地址
 * 
 * https://github.com/phpredis/phpredis
 */
namespace yii\redis;

use yii\base\Component;
use yii\db\Exception;
use yii\helpers\Inflector;


class RedisClient extends Component
{
	/**
	 * The redis client
	 * @var Redis
	 */
	protected $_client;
	
	/**
	 * The redis unix socket location
	 * @var unixSocket
	 */
	public $unixSocket=null;
	/**
	 * The redis server name
	 * @var string
	 */
	public $hostname = "localhost";
	/**
	 * Redis default prefix
	 * @var string
	 */
	public $prefix = "Yii.redis.";
	/**
	 * The redis server port
	 * @var integer
	 */
	public $port=6379;
	/**
	 * The database to use, defaults to 1
	 * @var integer
	 */
	public $database=1;
	/**
	 * The redis server password
	 * @var password
	 */
	public $password=null;
	/**
	 * The redis socket timeout, defaults to 0 (unlimited)
	 * @var timeout
	 */
	public $timeout=0;
	
	public $cluster = false;
	
	public $seeds = array();
	
	public function init()
	{
		if ($this->_client === null) {
			if($this->cluster){
				$this->_client = new \RedisCluster(NULL, $this->seeds);
			}
			else{
				$this->_client = new \Redis();
				if($this->unixSocket !== null)
					$this->_client->connect($this->unixSocket);
				else {
					$this->_client->connect($this->hostname, $this->port, $this->timeout);
				}
				
				if (isset($this->password)) {
					if ($this->_client->auth($this->password) === false) {
						throw new CException('Redis authentication failed!');
					}
				}
				
				$this->_client->select($this->database);
			}
			
			$this->_client->setOption(\Redis::OPT_PREFIX, $this->prefix);
		}
	}
	
	/**
	 *
	 * @param string $name
	 * @param array $params
	 * @return mixed
	 */
	public function __call($name, $params)
	{
		if($this->_client != null && method_exists($this->_client, $name)){
			return call_user_func_array(array($this->_client, $name), $params);
		}
		
		return parent::__call($name, $params);	
	}
}