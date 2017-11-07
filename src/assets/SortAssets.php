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
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'public/skin/default_skin/css/theme.css',
    ];
    public $js = [
        'public/vendor/jquery/jquery-1.11.1.min.js',
        'public/vendor/jquery/jquery_ui/jquery-ui.min.js',
        'public/js/bootstrap/bootstrap.min.js',
    ];

    //依赖包
    public $depends = [
        //这里写你的依赖包即可，没有就别写
    ];

    //导入当前页的功能js文件，注意加载顺序，这个应该最后调用
    public static function addPageScript($view, $jsfile) {
        $view->registerJsFile($jsfile, [SortAssets::className(), 'depends' => 'app\assets\AppAsset']);
    }

    //导入编辑器
    public static function addCkeditor($view) {
        $view->registerJsFile('/public/js/utility/ckeditor/ckeditor.js', [SortAssets::className(), 'depends' => 'app\assets\AppAsset']);
    }

}