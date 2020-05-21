<?php

use yii\helpers\Url;
use common\models\Element;
use yii\bootstrap\Progress;
use yii\helpers\ArrayHelper;
use common\models\Categories;
use \yii\helpers\StringHelper;
use kartik\datetime\DateTimePicker;


return [
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'width' => '20px',
    ],
    [
        'class' => 'kartik\grid\SerialColumn',
        'width' => '30px',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'id',
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'name',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'label' => 'Категория',
        'attribute' =>'category_id',
        'value' => 'category.name',
        'filter' => $categoryList,
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'description',
        'value' => function ($model) {
            return StringHelper::truncate($model->description, 10);
        }
    ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'param_done',
        // 'value' => function ($model) {
        //     return $model->param_done / $model->param_all;
        // }
        'format' => 'html',
        'value' => function($model) {
            return Progress::widget([
                'percent' => $model->param_done / $model->param_all * 100,
                'barOptions' => ['class' => 'progress-bar-success'],
                'options' => ['class' => 'progress-success active progress-striped'],
            ]);
        },
    ],
    // [
    //     'class'=>'\kartik\grid\DataColumn',
    //     'attribute'=>'param_all',
    // ],
    // [
        // 'class'=>'\kartik\grid\DataColumn',
        // 'attribute'=>'created_at',
    // ],
    [
        'class'=>'\kartik\grid\DataColumn',
        'attribute'=>'updated_at',
        'label' => 'Не позднее, чем указано',
        'format' => ['date', 'php:Y.m.d H:i:s'],

        'filter' => DateTimePicker::widget([
            'model' => $searchModel,
            'attribute' => 'date_to',
            'options' => ['placeholder' => 'не позднее, чем ...'],
            'convertFormat' => true,
            'pluginOptions' => [
                'autoclose'=> true,
                'format' => 'php:Y.m.d H:i:s',
                'startDate' => '01-Mar-2014 12:00 AM',
                'todayHighlight' => true
            ]
        ])
    ],
    [
        'class' => 'kartik\grid\ActionColumn',
        'dropdown' => false,
        'vAlign'=>'middle',
        'urlCreator' => function($action, $model, $key, $index) { 
                return Url::to([$action,'id'=>$key]);
        },
        'viewOptions'=>['role'=>'modal-remote','title'=>'View','data-toggle'=>'tooltip'],
        'updateOptions'=>['role'=>'modal-remote','title'=>'Update', 'data-toggle'=>'tooltip'],
        'deleteOptions'=>['role'=>'modal-remote','title'=>'Delete', 
                          'data-confirm'=>false, 'data-method'=>false,// for overide yii data api
                          'data-request-method'=>'post',
                          'data-toggle'=>'tooltip',
                          'data-confirm-title'=>'Are you sure?',
                          'data-confirm-message'=>'Are you sure want to delete this item'], 
    ],

];   