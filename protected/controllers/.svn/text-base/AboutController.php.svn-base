<?php

class AboutController extends Controller
{

	public function actionIndex()
	{
		$content = StaticPages::model()->findByPk('about');
		$menuItem = Menu::model()->getItemByUrl(Yii::app()->params->language);

		$content = $content ? $content->{'value_' . Yii::app()->params->language} : '';
    $temp = split('/',Yii::app()->request->requestUri);
    $meta_info = Menu::model()->get_meta($temp[count($temp)-1],Yii::app()->params->language);
		$this->render('index', array('content' => $content, 'menuItem' => $menuItem, 'meta' => $meta_info));
	}

}

?>