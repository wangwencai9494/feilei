<?php
/**
 * Created by PHPStrom.
 * User: Wencai
 * Date: 2017/11/2
 * Time: 17:30
 */
namespace zunxiang\fenlei\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%site_config}}".
 *
 * @property string $id
 * @property string $config_title
 * @property string $config_name
 * @property string $config_value
 */
class SiteConfig extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%site_config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['config_value'], 'string'],
            [['config_name','config_title'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'config_title' => 'Config Title',
            'config_name'  => 'Config Name',
            'config_value' => 'Config Value',
        ];
    }

}
