<?php

class MainController extends Controller
{
	public $layout = 'views/layouts/admin_column2.twig';

	public function actionIndex()
	{
		$this->render('index');
	}

	public function filters()
	{
		return array('accessControl');
	}

	public function accessRules()
	{
		return array
		(
			array	('allow', 'actions' => array('index'), 'users' => array('admin')),
			array('deny', 'users' => array('*'))
		);
	}

}