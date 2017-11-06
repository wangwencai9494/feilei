<?php
/**
 * Created by PHPStrom.
 * User: Wencai
 * Date: 2017/11/2
 * Time: 17:37
 */

namespace zunxiang\fenlei\models;

use Yii;

/**
 * This is the model class for table "{{%activity}}".
 *
 * @property string $id
 * @property integer $belong_type
 * @property integer $show_type
 * @property integer $attach_num
 * @property string $belong_id
 * @property string $url
 * @property string $cover
 * @property string $name
 * @property string $description
 * @property integer $category_id
 * @property string $created_at
 * @property string $start_time
 * @property string $end_time
 * @property integer $status
 * @property integer $is_deleted
 * @property integer $extend
 * @property string $priority
 * @property integer $position
 * @property integer $fixed_position
 */
class Activity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%activity}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['belong_type', 'belong_id', 'category_id', 'created_at', 'start_time', 'end_time', 'status', 'extend', 'fixed_position' ,'priority', 'position'], 'integer'],
            [['position'], 'required'],
            [['url'], 'string', 'max' => 255],
            [['cover', 'description'], 'string', 'max' => 100],
            [['name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'belong_type' => '类型 1：帖子活动 2：身边活动 3：外链活动',
            'belong_id' => '帖子id或身边id',
            'url' => '跳转地址',
            'cover' => '封面',
            'name' => '活动名称',
            'description' => '描述',
            'category_id' => '分类id',
            'created_at' => 'Created At',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'status' => '活动状态0:关闭 1：在播 2：尚未开始 3：已结束',
            'extend' => '是否是广告',
            'priority' => '优先级',
            'fixed_position' => '固定位置',
            'position' => '广告位置 1首页,2轮播4活动',
        ];
    }

}
