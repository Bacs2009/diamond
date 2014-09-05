<?php

class UrlManager extends CUrlManager
{
/*
	public $languages = array('ua');
	public $langParam = 'lang';

	public function parsePathInfo($pathInfo)
	{
		parent::parsePathInfo($pathInfo);
    
		if(isset($_GET[$this->langParam]) && in_array($_GET[$this->langParam], $this->languages))
		{
			Yii::app()->language = $_GET[$this->langParam];
		}
	}

	public function createLanguageUrl($route, $params = array(), $ampersand = '&')
	{
		if(!isset($params[$this->langParam]) && Yii::app()->language !== Yii::app()->sourceLanguage)
		{
			$params[$this->langParam] = Yii::app()->language;
		}

		return parent::createUrl($route, $params, $ampersand);
	}
*/

	public function createLanguageUrl($route, $params = array(), $ampersand = '&')
	{
		if(!isset($params['language']) && isset(Yii::app()->params->locales[Yii::app()->params->language]))
		{
			$params['language'] = Yii::app()->params->language;
		}

		return parent::createUrl($route, $params, $ampersand);
	}

	public function createAbsoluteLanguageUrl($route, $params = array(), $ampersand = '&')
	{
		return Yii::app()->createAbsoluteUrl('/') . $this->createLanguageUrl($route, $params, $ampersand);
	}

}

?>