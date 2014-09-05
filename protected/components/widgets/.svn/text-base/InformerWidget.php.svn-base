<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 18.09.12
 * Time: 11:44
 * To change this template use File | Settings | File Templates.
 */
class InformerWidget extends CWidget
{

	public function init()
	{
		if(Yii::app()->controller->route !== 'site/index')
		{
			$Path = explode('/', Yii::app()->controller->route);
			$Result = array();

			if($Path[0] === 'news') $Result = StaticData::model()->getSerialized('informer_stb');
			elseif($Path[0] === 'clips') $Result = StaticData::model()->getSerialized('informer_smachno');

			$this->render('informer', array('path' => $Path, 'data' => $Result));
		}
	}

}