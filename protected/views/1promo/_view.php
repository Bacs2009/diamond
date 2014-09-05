<?php
/* @var $this PromoController */
/* @var $data Promo */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name_ru')); ?>:</b>
	<?php echo CHtml::encode($data->name_ru); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name_en')); ?>:</b>
	<?php echo CHtml::encode($data->name_en); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descr_ru')); ?>:</b>
	<?php echo CHtml::encode($data->descr_ru); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descr_en')); ?>:</b>
	<?php echo CHtml::encode($data->descr_en); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('text_ru')); ?>:</b>
	<?php echo CHtml::encode($data->text_ru); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('text_en')); ?>:</b>
	<?php echo CHtml::encode($data->text_en); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('active')); ?>:</b>
	<?php echo CHtml::encode($data->active); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('sort')); ?>:</b>
	<?php echo CHtml::encode($data->sort); ?>
	<br />

	*/ ?>

</div>