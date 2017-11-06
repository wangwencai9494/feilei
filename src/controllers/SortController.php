<?php
/**
 * Created by PHPStrom.
 * User: Wencai
 * Date: 2017/11/2
 * Time: 10:12
 */
namespace zunxiang\fenlei\controllers;

use yii;
use zunxiang\fenlei\actions\sort\GetSortListAction;

class SortController extends BaseController{

    public function actions()
    {
        return [
            'get-sort-list'=>[
                'class'=> GetSortListAction::classname(),
                'fids'=>Yii::$app->request->post('fids'),
            ]
        ];
    }
}
