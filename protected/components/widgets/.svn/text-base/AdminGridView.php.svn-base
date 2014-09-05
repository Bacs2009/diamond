<?php

Yii::import('zii.widgets.grid.CGridView');

class AdminGridView extends CGridView
{

	var $summaryText = 'Показано {start}-{end} из {count} записей';

	var $pager = array
	(
		'header' => 'Страницы: ',
		'firstPageLabel' => '&lt;&lt;',
		'prevPageLabel' => '&lt; Предыдущая',
		'nextPageLabel' => 'Следующая &gt;',
		'lastPageLabel' => '&gt;&gt;',
		'firstPageCssClass' => '',
		'lastPageCssClass' => ''
	);

	public function init()
	{
		$LastColumn = array
		(
			'class' => 'CButtonColumn',
			'template' => '{view}{update}{delete}',
			'buttons' => array
			(
				'view' => array('label' => 'Просмотр'),
				'update' => array('label' => 'Редактировать'),
				'delete' => array('label' => 'Удалить')
			)
		);

		$Last = sizeof($this->columns) - 1;

		// Если в шаблоне не было указано других параметров кроме названий полей
		if(!is_array($this->columns[$Last]) || !isset($this->columns[$Last]['buttons']))
		{
			$this->columns = array_merge($this->columns, array($LastColumn));
		}
		else
		{
			// Если произведена кастомизация кнопок
			$Buttons = isset($this->columns[$Last]['buttons']) ? $this->columns[$Last]['buttons'] : array();

			$this->columns[$Last] = array_merge($LastColumn, $this->columns[$Last]);

			// Объединяем кастомизацию и значения по умолчанию для кнопок
			if(!empty($Buttons)) $this->columns[$Last]['buttons'] = array_merge($LastColumn['buttons'], $Buttons);
		}

		parent::init();
	}

}

?>