<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 17-11-7
 * Time: 下午10:47
 */

namespace zunxiang\fenlei\assets;

use yii\web\AssetBundle as BaseAsset;

class SortAssets extends BaseAsset
{
    public $basePath = '@assets';

    public $baseUrl = '@assetsurl';

    public $css = [
        'css/style.css',
    ];
    public $js = [
        'js/jquery-1.11.2.min.js',
        'js/jquery-1.8.3.min.js',
        'js/swiper.js',
    ];

    //依赖包
    public $depends = [
        //这里写你的依赖包即可，没有就别写
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

    //导入当前页的功能js文件，最后调用
    public static function addScript($view, $jsfile) {
        $view->registerJsFile($jsfile, [SortAssets::className(), 'depends' => 'zunxiang\fenlei\assets\SortAssets']);
    }

    //定义加载css方法
    public static function addCss($view, $cssfile) {
        $view->registerCssFile($cssfile, [SortAssets::className(), 'depends' => 'zunxiang\fenlei\assets\SortAssets']);
    }

//
//    //导入编辑器
//    public static function addCkeditor($view) {
//        $view->registerJsFile('/public/js/utility/ckeditor/ckeditor.js', [SortAssets::className(), 'depends' => 'app\assets\AppAsset']);
//    }

}