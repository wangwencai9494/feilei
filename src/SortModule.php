<?php
/**
 * Created by PHPStrom.
 * User: Wencai
 * Date: 2017/11/1
 * Time: 15:29
 */

namespace zunxiang\fenlei;

use yii\base\Module;

class SortModule extends Module
{
    public $charset = 'UTF-8';
    public $secret_key = 'xxxxxx';
    public $url = 'http://localhost/GIT_work/my_discuz/DZ_X3.2/plugin.php?id=qianfan:index';


    public function init(){

        parent::init();

        define('FORUM_URL', $this->url);
        define('FORUM_SECRET_KEY', $this->secret_key);
        define('FORUM_CHARSET', strtoupper($this->charset));

    }
}