<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 16/7/11
 * Time: 上午11:16
 */
namespace  v300\components\thriftClient;

use Yii;
use Thrift\ClassLoader\ThriftClassLoader;
$loader = new ThriftClassLoader();
$loader->registerDefinition('components', dirname(dirname(__DIR__)));
$loader->register();
use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\THttpClient;
use Thrift\Transport\TBufferedTransport;


class ThriftClient
{
    /**
     * 获取实例
     * @var array
     */
    private static $instance = array();


    public static function instance($serverName, $newOne = false)
    {
        if ($newOne) {
            unset(self::$instance[$serverName]);
        }
        if (!isset(self::$instance[$serverName])) {
            self::$instance[$serverName] = new ThriftClientInstance($serverName);
        }
        return self::$instance[$serverName];
    }

    public static function type($typeName, $vales)
    {
        $type_name = explode('.', $typeName);
        $class_name = '\components\thriftClient\\' . $type_name[0] . '\\' . ucfirst($type_name[1]);
        return new $class_name($vales);
    }

}

class ThriftClientInstance
{
    public $instance=null;
    public $transport=null;

    public function __construct($serverName)
    {
        $config = Yii::$app->params['thriftServer'][$serverName];

        $socket = new THttpClient($config['host'],$config['port'],$config['uri']);
        $socket->setTimeoutSecs(10000);

        $this->transport = new TBufferedTransport($socket, 1024, 1024);
        $protocol = new TBinaryProtocol($this->transport);
        $clientClassName = '\components\thriftClient\\'.$config['client'];
        $this->instance = new $clientClassName($protocol);
        $this->transport->open();
    }

    public function __destruct()
    {
        $this->transport->close();
    }

    public function __call($methodName,$arguments)
    {
        return call_user_func_array(array($this->instance,$methodName),$arguments);
    }


}
