<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 18.09.12
 * Time: 11:44
 * To change this template use File | Settings | File Templates.
 */
class PlashkaWidget extends CWidget
{

	public function init()
	{
		$this->render('plashka', array('menu' => StaticData::model()->getSerialized('top_plashka')));
	}

}
