<?php
/* @var $this PromoController */
/* @var $model Promo */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'promo-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name_ru'); ?>
		<?php echo $form->textField($model,'name_ru',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'name_ru'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name_en'); ?>
		<?php echo $form->textField($model,'name_en',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'name_en'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descr_ru'); ?>
		<?php echo $form->textArea($model,'descr_ru',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'descr_ru'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'descr_en'); ?>
		<?php echo $form->textArea($model,'descr_en',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'descr_en'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text_ru'); ?>
		<?php echo $form->textArea($model,'text_ru',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'text_ru'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'text_en'); ?>
		<?php echo $form->textArea($model,'text_en',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'text_en'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'active'); ?>
		<?php echo $form->textField($model,'active'); ?>
		<?php echo $form->error($model,'active'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'sort'); ?>
		<?php echo $form->textField($model,'sort'); ?>
		<?php echo $form->error($model,'sort'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->