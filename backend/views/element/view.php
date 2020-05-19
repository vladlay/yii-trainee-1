<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Element */
?>
<div class="element-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'category_id',
            'description:ntext',
            'param_done',
            'param_all',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
