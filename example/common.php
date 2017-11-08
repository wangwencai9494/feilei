<?php
/**
 * Created by PHPStrom.
 * User: Wencai
 * Date: 2017/11/3
 * Time: 9:37
 */


error_reporting(E_ALL);
ini_set('display_errors', 'On');

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

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

Yii::setAlias('@assets', 'D:/wamp/apache2/htdocs/My_Work/fenlei/src/static');
Yii::setAlias('@assetsurl', '/My_Work/fenlei/src/static');

//1.composer install todo
//2.css and js into view todo  http://www.yiiframework.com/doc-2.0/yii-web-assetbundle.html
//3.else function todo

Yii::$app->setComponents([
    'db' => [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=app',
        'username' => 'root',
        'password' => '123456',
        'tablePrefix' => 's_',
        'enableSchemaCache' => true,
        'schemaCacheDuration' => 600,
        'charset' => 'utf8mb4',
        'attributes' => [
            PDO::ATTR_PERSISTENT => true
        ],
    ],
    'response' => [
        'class' => \yii\web\Response::className(),
        'format' => yii\web\Response::FORMAT_HTML,
        'charset' => 'UTF-8',
    ]
]);

Yii::$app->setModule('sort-module', new \zunxiang\fenlei\SortModule('sort-module', null));

$module = Yii::$app->getModule('sort-module');
