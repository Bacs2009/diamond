<?php

Yii::import('zii.widgets.CListView');

class AdminListView extends CListView
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
		parent::init();
	}

}

?>