<?php
/**
 * Created by PHPStrom.
 * User: Wencai
 * Date: 2017/11/3
 * Time: 9:31
 */
namespace zunxiang\fenlei\modelsext;

use yii;

class Activity extends \zunxiang\fenlei\models\Activity
{

    //首页顶部轮播广告
    public static function getIndexTopAd()
    {
        $activities = Yii::$app->db->cache(function()
        {
            return Activity::findByPosition(Activity::HOME_SLIDER, null,5);
        }, 10);
        /* @var $activities Activity[] */

        $ad = [];
        foreach($activities as $v)
        {
            $data = [];
            $data['id'] = $v->id;
            if($v->belong_type == 8) {
                $data['to_type'] = 3;
                $data['url'] = ClientJump::getUrl('store');
            }
            else {
                $data['to_type'] = (int)$v->belong_type;//类型 1：帖子 2：话题 3：外链 4：版块 5：本地圈  6：外链外部浏览器  7：热门 8:商城首页
                $data['url']      = $v->url;
            }

            $data['to_id']    = $v->belong_id;
            $data['name']     = $v->name;
            $data['desc']     = $v->description;
            $data['img']      = Img::src($v->cover);
            $data['is_ad']    = $v->extend == 1 ? 1 : 0;//是否显示广告标签
            $ad[] = $data;

        }
        return $ad;
    }
}