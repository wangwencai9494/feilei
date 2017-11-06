<?php
/**
 * Created by PHPStrom.
 * User: Wencai
 * Date: 2017/11/3
 * Time: 10:13
 */
namespace zunxiang\fenlei\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "s_forum".
 *
 * @property string $id
 * @property integer $fid
 * @property integer $fup
 * @property string $fname
 * @property string $default_fname
 * @property string $descrip
 * @property integer $showextra
 * @property integer $status
 * @property string $logo
 * @property string $praise_config
 * @property string $reply_config
 * @property string $favor_config
 * @property string $favor_real
 * @property integer $vieworder
 * @property string $direct_url
 * @property integer $show_type
 * @property integer $top_date
 * @property string $top_limit
 * @property integer $allow_posts
 * @property string $reasion
 * @property string $tap_setting
 * @property integer $can_del
 * @property string $created
 * @property string $updated
 */
class Forum extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 's_forum';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fid', 'fup', 'showextra', 'status', 'favor_config', 'favor_real', 'vieworder', 'show_type', 'top_date', 'top_limit', 'allow_posts', 'can_del', 'created', 'updated'], 'integer'],
            [['fname', 'default_fname'], 'string', 'max' => 20],
            [['descrip', 'tap_setting'], 'string', 'max' => 255],
            [['logo'], 'string', 'max' => 128],
            [['praise_config', 'reply_config', 'direct_url', 'reasion'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fid' => 'Fid',
            'fup' => 'Fup',
            'fname' => 'Fname',
            'default_fname' => 'Default Fname',
            'descrip' => 'Descrip',
            'showextra' => 'Showextra',
            'status' => 'Status',
            'logo' => 'Logo',
            'praise_config' => 'Praise Config',
            'reply_config' => 'Reply Config',
            'favor_config' => 'Favor Config',
            'favor_real' => 'Favor Real',
            'vieworder' => 'Vieworder',
            'direct_url' => 'Direct Url',
            'show_type' => 'Show Type',
            'top_date' => 'Top Date',
            'top_limit' => 'Top Limit',
            'allow_posts' => 'Allow Posts',
            'reasion' => 'Reasion',
            'tap_setting' => 'Tap Setting',
            'can_del' => 'Can Del',
            'created' => 'Created',
            'updated' => 'Updated',
        ];
    }
}
