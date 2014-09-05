<?php
/* @var $this PromoController */
/* @var $model Promo */

$this->breadcrumbs=array(
	'Promos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Promo', 'url'=>array('index')),
	array('label'=>'Manage Promo', 'url'=>array('admin')),
);
?>

<h1>Create Promo</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>