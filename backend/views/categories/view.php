<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Categories */
?>
<div class="categories-view">
 
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
