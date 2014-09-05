<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 18.09.12
 * Time: 12:09
 * To change this template use File | Settings | File Templates.
 */
class FooterLinksWidget extends CWidget
{

	public function init()
	{
		$this->render('footer_links', array('items' => FooterLinks::model()->getItems(Yii::app()->params->language)));
	}

}

?>