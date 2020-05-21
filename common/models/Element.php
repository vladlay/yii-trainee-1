<?php

namespace common\models;

use Yii;
use yii\db\Expression;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "element".
 *
 * @property int $id
 * @property string $name
 * @property int $category_id
 * @property string $description
 * @property float $param_done
 * @property float $param_all
 * @property int $created_at
 * @property int $updated_at
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

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'category_id', 'description', 'param_done', 'param_all'], 'required'],
            [['name', 'description'], 'string', 'max' => 512],
            [['category_id', 'created_at', 'updated_at'], 'integer'],
            [['param_done', 'param_all'], 'number'],
            ['param_done', 'compare', 'compareAttribute' => 'param_all', 'operator' => '<=', 'type' => 'number'],            
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
            'description' => 'Description',
            'param_done' => 'Param Done',
            'param_all' => 'Param All',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'category.name' => 'Категория',
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

    public function getCategoriesList() {
        return ArrayHelper::map(Categories::find()->all(), 'id', 'name');
    }

    // public function getCategoriesNames()
    // {
    //     $cat_names = Element::find()
    //         ->select('element.category_id', 'categories.name')
    //         ->joinWith('categories')
    //         ->all();
    //     return $cat_names;
    // }
}
// $names = Categories::find()
//             ->select('name')
//             // ->from('categories')
//             ->all();
//             $res = [];
//             foreach ($names as $name) {
//                 $res[] = $name->name;
//             }
//         return $res;
//     }

// [
//     'catehory_id' => 'categories.name'
// ]
// [
//     'id' => 'name'
// ]
// [
//     'categories.name' => 'catehory_id'
// ]