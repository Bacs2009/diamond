<?php

class BoutiquesController extends Controller
{

	public function actionIndex()
	{
		$cities = array();
		$shops = Shops::model()->findAll();
		$menuItem = Menu::model()->getItemByUrl(Yii::app()->params->language);
    $temp = split('/',Yii::app()->request->requestUri);
    $meta_info = Menu::model()->get_meta($temp[count($temp)-1],Yii::app()->params->language);
		if($shops) {
			foreach($shops as $value) {
			  $cities[$value->city_id] = '';
			}

			$cities = CityItem::model()->findAllByPk(array_keys($cities));
			
		}
		
		$this->render('index', array('shops' => $shops, 'cities' => $cities, 'menuItem' => $menuItem,'meta' => $meta_info));
	}

}

