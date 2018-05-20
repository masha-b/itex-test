<?php
$this->pageTitle=Yii::app()->name . ' - Contact Us';
$this->breadcrumbs=array(
	'Контакты',
);
?>

<h1>Контакты</h1>

<?php if(Yii::app()->user->hasFlash('contact')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>

<p>
Если у Вас есть деловые предлжения или вопросы вы можете отправить их нам заполнив форму ниже.
</p>

<div class="form">

<?php
$form = $this->beginWidget('CActiveForm', array(
        'id' => 'contact-form',
        'enableClientValidation'=>false,
        'enableAjaxValidation'=>true,
        'clientOptions'=>array(
            'validateOnChange'=>true,
            'validateOnSubmit'=>true,
            //'afterValidate'=>'js:validateListing',
        ),
        'htmlOptions' => array(
            'enctype' => 'multipart/form-data'
        )
    )
);

?>

	<p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
        <?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email'); ?>
        <?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'subject'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'body'); ?>
		<?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50)); ?>
        <?php echo $form->error($model,'body'); ?>
	</div>

    <?

    $this->widget('xupload.XUpload', array(
            'url' => Yii::app()->createUrl("site/upload"),
            'model' => $attachModel,
            'showForm' => false,
            'attribute' => 'file',
            'htmlOptions' => $form->htmlOptions,
            'autoUpload' => true,
            'multiple' => true,
            'options' => array(
                'maxFileSize' => 3000000,
                'acceptFileTypes' => "js:/(\.|\/)(jpe?g|gif)$/i",
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

	<?php if(CCaptcha::checkRequirements()): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		<div>
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'verifyCode'); ?>
        <?php echo $form->error($model,'verifyCode'); ?>
		</div>
		<div class="hint">Please enter the letters as they are shown in the image above.
		<br/>Letters are not case-sensitive.</div>
	</div>
	<?php endif; ?>

	<div class="row submit">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>

