<?php

class ServiceController extends Controller
{

	public function actionIndex()
	{
		$content = StaticPages::model()->findByPk('service');
    $temp = split('/',Yii::app()->request->requestUri);
    $meta_info = Menu::model()->get_meta($temp[count($temp)-1],Yii::app()->params->language);
		$this->render('index', array('meta' => $meta_info,'content' => $content ? $content->{'value_' . Yii::app()->params->language} : ''));
	}

}

?>