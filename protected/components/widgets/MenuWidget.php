<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 18.09.12
 * Time: 12:09
 * To change this template use File | Settings | File Templates.
 */
class MenuWidget extends CWidget
{

	public function init()
	{
		$items = Menu::model()->getItems(Yii::app()->params->language);
		$route = $this->getController()->getRoute();

		$url = trim(Yii::app()->urlManager->createAbsoluteLanguageUrl('site/index'), '/');

		foreach($items as $key => $value)
		{
			$items[$key]['id'] = $value['id'];
			$items[$key]['active'] = $this->isItemActive($value['url'], $route);
			$items[$key]['url'] = stripos($value['url'], 'http') !== 0 ? $url . '/' . $value['url'] : $value['url'];
		}

		$this->render('menu', array('items' => $items));
	}

	protected function isItemActive($url, $route)
	{
		$url = explode('/', trim($url, '/'));
		$route = explode('/', $route);

		$count = sizeof($url);
		if($count <= sizeof($route))
		{
			for($i = 0; $i < $count; $i++)
			{
				if($url[$i] !== $route[$i]) return false;
			}

			return true;
		}

		return false;
	}

}

?>