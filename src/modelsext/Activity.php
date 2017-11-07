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
    const OFF      = 0;
    const ON       = 1;
    const NO_START = 2;
    const END      = 3;

    const POST = 1;
    const SIDE = 2;
    const LINK = 3;

    const AD  = 1;
    const FIX = 2;

    const TAG_COVER_WIDTH  = 640;
    const TAG_COVER_HEIGHT = 200;

    const IS_DELETED_NO = 0;   //是否删除  否
    const IS_DELETED_YES = 1;  //是否删除  是

    const HOME     = 1;
    const SLIDE    = 2;
    const ACTIVITY = 4;
    const DISCOVER = 8;
    const HOME_SLIDER = 16;
    const H5_SIGN = 32;
    const SIDE_LIST = 64;
    const THREAD_TOP = 128;//帖子详情页
    const THREAD_HOT = 256;//帖子本版热贴(无图)
    const MEET_LIST = 512;  //交友列表页
    const WAP_THREAD_UP = 1024;  //WAP正文上
    const WAP_THREAD_MIDDLE = 2048;  //wap帖子详情页正文下
    const WAP_THREAD_BOTTOM = 4096; //wap帖子详情页评论上
    const WEATHER = 8192;//天气页

    public $position_config = [
        Activity::HOME        => '首页',
        Activity::SLIDE       => '巷友圈轮播',
        Activity::ACTIVITY    => '活动',
        Activity::DISCOVER    => '发现窗',
        Activity::HOME_SLIDER => '首页轮播',
        Activity::H5_SIGN => 'h5签到',
        Activity::SIDE_LIST => '本地圈推荐列表',
        Activity::THREAD_TOP => '帖子详情关联阅读上方通栏',
        Activity::THREAD_HOT => '帖子详情关联阅读文字推荐',
        Activity::MEET_LIST => '交友列表页',
        Activity::WAP_THREAD_UP => 'wap帖子详情页正文上',
        Activity::WAP_THREAD_MIDDLE => 'wap帖子详情页正文下',
        Activity::WAP_THREAD_BOTTOM => 'wap帖子详情页评论上',
        self::WEATHER         => '天气详情页'
    ];
    //首页顶部轮播广告
    public static function getIndexTopAd()
    {
        $ad = [];
        $activities = Activity::findByPosition(Activity::HOME_SLIDER, null,5);
        foreach($activities as $v)
        {
            $data = [];
            $data['id'] = $v->id;
            if($v->belong_type == 8) {
                $data['to_type'] = 3;
                $data['url'] = '';
            }
            else {
                $data['to_type'] = (int)$v->belong_type;//类型 1：帖子 2：话题 3：外链 4：版块 5：本地圈  6：外链外部浏览器  7：热门 8:商城首页
                $data['url']      = $v->url;
            }

            $data['to_id']    = $v->belong_id;
            $data['name']     = $v->name;
            $data['desc']     = $v->description;
            $data['img']      = '';
            $data['is_ad']    = $v->extend == 1 ? 1 : 0;//是否显示广告标签
            $ad[] = $data;

        }
        return $ad;
    }
    public static function findByPosition($position, $page = null, $limit = 20)
    {

        //阿西吧  需要修改limit  begin
        $query_no_start = Activity::find()
            ->where(['status'=>Activity::NO_START])
            ->andWhere('position & :position = :position',[':position'=>$position]);
        if($page !== null and $position != Activity::DISCOVER)
        {
            $query_no_start->andWhere(['>','fixed_position',$page*10]);
            $query_no_start->andWhere(['<=','fixed_position',($page+1)*10]);
        }
        $count_no_start = $query_no_start->count();
        //修改limit  end

        $time = time();
        $query = Activity::find()
            ->where(['status'=>[Activity::ON,Activity::NO_START]])
//            ->andWhere(['>', 'end_time'  , $time])
//            ->andWhere(['<', 'start_time', $time])
            ->andWhere(['is_deleted'=>Activity::IS_DELETED_NO])
            ->andWhere('position & :position = :position',[':position'=>$position])
            ->limit($limit + $count_no_start);
        if($page !== null and $position != Activity::DISCOVER)
        {
            $query->andWhere(['>','fixed_position',$page*10]);
            $query->andWhere(['<=','fixed_position',($page+1)*10]);
        }

        if($position == Activity::HOME_SLIDER  || $position == Activity::DISCOVER  ||  $position == Activity::THREAD_HOT)
            $query->orderBy('priority desc');
        else
            $query->orderBy('fixed_position asc, priority desc, created_at desc');

        $activities = Yii::$app->db->cache(function()use($query){
            return $query->all();
        }, 30);

        /* @var $activities Activity[] */
        $list = [];
        foreach($activities as $v){
            if($v->start_time <= $time){
                if($v->status != Activity::ON){
                    $v->status = Activity::ON;
                    $v->save();
                }
            }else{
                $v->status = Activity::NO_START;
                $v->save();
                continue;
            }
            if($v->end_time < $time){
                $v->status = Activity::END;
                $v->save();
                continue;
            }
            $list[] = $v;
        }
        $list = array_slice($list, 0, $limit);
        return $list;
    }
}