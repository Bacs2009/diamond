<?php
/* @var $this PromoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Promos',
);

$this->menu=array(
	array('label'=>'Create Promo', 'url'=>array('create')),
	array('label'=>'Manage Promo', 'url'=>array('admin')),
);
?>

<h1>Promos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
