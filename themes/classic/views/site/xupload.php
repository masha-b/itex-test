<?php
$this->widget('xupload.XUpload', array(
        'url' => Yii::app()->createUrl("site/upload"),
        'model' => $model,
        //'showForm' => false,
        'attribute' => 'file',
        'multiple' => true,
        'options' => array(
            'maxFileSize' => 3000000,
            'acceptFileTypes' => "js:/(\.|\/)(jpe?g|png)$/i",
        )
    )
);
?>

<div id="dropzone">Перетащите файл сюда для загрузки</div>
<style>
    #dropzone {
        background: #C6C6C6;
        width: 100%;
        text-align: center;
        font-weight: bold;
        padding: 50px 0;
    }
</style>