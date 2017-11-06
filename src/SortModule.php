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
    public $charset;
    public $url;

    public function init(){

        parent::init();

        define('FORUM_URL', $this->url);
        define('FORUM_CHARSET', strtoupper($this->charset));

    }
}