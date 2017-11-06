<?php
/**
 * Created by PHPStrom.
 * User: Wencai
 * Date: 2017/11/3
 * Time: 9:37
 */


error_reporting(E_ALL);
ini_set('display_errors', 'On');

defined('YII_DEBUG') or define('YII_DEBUG', 0);
defined('YII_ENV') or define('YII_ENV', 'prod');

require_once(dirname(__FILE__) . '/../vendor/yiisoft/yii2/Yii.php');
require_once(dirname(__FILE__) . '/../vendor/autoload.php');
@(Yii::$app->charset = 'UTF-8');

$application = new yii\web\Application([
    'id' => 'example',
    'basePath' => './',
    'params' => [
        'secret_key' => '3344'
    ]
]);


Yii::$app->setComponents([
    'db' => [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=61.160.251.70;dbname=side',
        'username' => 'hlxdev',
        'password' => 'hlx_dev.123456@#',
        'tablePrefix' => 's_',
        'enableSchemaCache' => true,
        'schemaCacheDuration' => 600,
        'charset' => 'utf8mb4',
        'attributes' => [
            PDO::ATTR_PERSISTENT => true
        ],
    ],
    'redis' => [
        'class' => \qianfan\redis\Connection::className(),
        'hostname' => '127.0.0.1',
        'port' => '6379',
        'password' => null,
        'database' => 1,
    ],
    'response' => [
        'class' => \yii\web\Response::className(),
        'format' => yii\web\Response::FORMAT_HTML,
        'charset' => 'UTF-8',
    ]
]);

Yii::$app->setModule('bbs-stream', new \zunxiang\bbsstream\BbsStream('bbs-stream', null, [
    'redis' => 'redis'
]));

$module = Yii::$app->getModule('bbs-stream');

function sign($params, $secret_key)
{
    $nonce = rand(10000, 99999);
    $timestamp = time();
    $array = array($nonce, $timestamp, $secret_key);
    sort($array, SORT_STRING);
    $token = md5(implode($array));
    $params['nonce'] = $nonce;
    $params['timestamp'] = $timestamp;
    $params['token'] = $token;

    $params = array_merge($params, $get_params);

    $url .= '?';
    foreach ($params as $k => $v) {
        $url .= $k . '=' . $v . '&';
    }
    $url = rtrim($url, '&');
}