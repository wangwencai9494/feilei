<?php
/**
 * Created by PHPStrom.
 * User: Wencai
 * Date: 2017/11/7
 * Time: 10:41
 */
require_once('./common.php');

$params = '';

Yii::$app->request->setBodyParams([
    'category' => 2,
    'page' => 0,
    'cursor' => 0,
    'codeSign' => '3344'
]);

var_dump($module->runAction('sort/get-sort-list', []));