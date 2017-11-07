<?php
/**
 * Created by PHPStrom.
 * User: Wencai
 * Date: 2017/11/3
 * Time: 9:40
 */
namespace zunxiang\fenlei\modelsext;

use yii;

class SiteConfig extends \zunxiang\fenlei\models\SiteConfig
{

    public static function getVal($key = ''){
        if(!$key){
            return '';
        }
        $configs = SiteConfig::find()->asArray()->all();
        if( !empty($configs) ) {
            $cfg = [];
            foreach ($configs as $config) {
                $cfg[$config['config_name']] = $config['config_value'];
            }
        }
        if( !empty($cfg) && isset($cfg[$key]) )
        {
            return $cfg[$key];
        }

        return false;

        if( Yii::$app->cache->exists('qianfan-site-config') )
        {
            $cfg = Yii::$app->cache->get('qianfan-site-config');
            if( !empty($cfg) && isset($cfg[$key]) )
            {
                return $cfg[$key];
            }
        }
        else
        {
            $configs = SiteConfig::find()->asArray()->all();
            if( !empty($configs) )
            {
                $cfg = [];
                foreach( $configs as $config )
                {
                    $cfg[$config['config_name']] = $config['config_value'];
                }
                if( !empty($cfg) )
                {
                    Yii::$app->cache->set( 'qianfan-site-config', $cfg );
                }
            }
        }
        if( !empty($cfg) && isset($cfg[$key]) )
        {
            return $cfg[$key];
        }

        return false;
    }

}