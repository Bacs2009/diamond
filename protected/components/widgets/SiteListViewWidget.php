<?php

Yii::import('zii.widgets.CListView');

class SiteListViewWidget extends CListView
{

	var $pager = array
	(
		'header' => '<span>Сторінки:</span>',
		'firstPageLabel' => 'На початок',
		'lastPageLabel' => 'В кінець',
		'prevPageLabel' => '&nbsp;',
		'nextPageLabel' => '&nbsp;',
		'cssFile' => '/css/pager.css?v=1'
	);

	public function init()
	{
		parent::init();
	}

}

?>