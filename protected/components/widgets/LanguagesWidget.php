<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 18.09.12
 * Time: 12:09
 * To change this template use File | Settings | File Templates.
 */
class LanguagesWidget extends CWidget
{

	public $languages = array('ru' => 'ру', 'ua' => 'укр', 'en' => 'англ');
	public $language = 'ru';

	public function init()
	{
	/*	$absoluteUrl = Yii::app()->createAbsoluteUrl('/');
		$url = Yii::app()->request->requestUri;
		$languages = array();

		if(strpos($url, '/ua/') === 0)
		{
			$url = substr($url, 3);
		}

		foreach($this->languages as $key => $value)
		{
			$language = array
			(
				'title' => $value,
				'href' => $absoluteUrl . ($this->language !== $key ? '/' . $key : '') . $url,
				'options' => array()
			);

			if(Yii::app()->params->language == $key)
			{
				$language['options']['class'] = 'b-active';
			}

			$languages[] = $language;
		}
*/
		//$this->render('languages', array('languages' => $languages));
		$absoluteUrl = Yii::app()->createAbsoluteUrl('/');
    $url = Yii::app()->request->requestUri;
    $temp = split('/ua/',$url);
    $temp1 = split('/en/',$url);
    //print_r($temp);
    if(count($temp) > 1){ //ua
      $link_ru = $absoluteUrl.'/'.str_replace('/en/','',str_replace('/ua/','',$url));
      $link_ua = '';
      $link_en = $absoluteUrl.'/en/'.str_replace('/ua/','',$url);
    }else if(count($temp1) > 1){ //en
      $link_ua = $absoluteUrl.'/ua/'.str_replace('/en/','',$url);
      $link_ru = $absoluteUrl.'/'.str_replace('/en/','',str_replace('/ua/','',$url));
      $link_en = '';
    }else{ //ru
      $link_ua = $absoluteUrl.'/ua/'.$url;
      $link_ru = '';
      $link_en = $absoluteUrl.'/en/'.$url;
    }
    $link_ru = str_replace('//','/',$link_ru);
	$link_ua = str_replace('//','/',$link_ua);
	$link_en = str_replace('//','/',$link_en);
	$link_ru = str_replace('http:/','http://',$link_ru);
	$link_ua = str_replace('http:/','http://',$link_ua);
	$link_en = str_replace('http:/','http://',$link_en);
    $this->render('languages', array('link_ru' => $link_ru,'link_ua' => $link_ua, 'link_en' => $link_en));
	}

}

?>