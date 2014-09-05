<?php

class AdminOrderingWidget extends CWidget
{

	public $buttonName = 'Сохранить';

	public $items;

	public $itemId = 'id';

	public $imgTitle = 'title';

	public $imgName;

	public function init()
	{
		Yii::app()->clientScript->registerScriptFile('/js/order.box.js');

		$this->render('adminordering', array('button' => $this->buttonName, 'items' => $this->items, 'title' => $this->imgTitle, 'img' => $this->imgName, 'id' => $this->itemId));
	}

}

?>