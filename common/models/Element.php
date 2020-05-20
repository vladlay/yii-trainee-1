<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "element".
 *
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property string $describ
 * @property float $param_done
 * @property float $param_all
 * @property int $created_at
 * @property int $update_at
 *
 * @property Categories $category
 */
class Element extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'element';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'category_id', 'describ', 'param_done', 'param_all', 'created_at', 'update_at'], 'required'],
            [['category_id', 'created_at', 'update_at'], 'integer'],
            [['describ'], 'string'],
            [['param_done', 'param_all'], 'number'],
            [['name'], 'string', 'max' => 512],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'category_id' => 'Category ID',
            'describ' => 'Describ',
            'param_done' => 'Param Done',
            'param_all' => 'Param All',
            'created_at' => 'Created At',
            'update_at' => 'Update At',
            'category.name'=>'Категория'
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }
}
