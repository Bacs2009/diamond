<?php

class ServiceController extends Controller
{

	public $layout = 'views/layouts/admin_column2.twig';

	private $pageKey = 'service';

	public function actionIndex()
	{
		$sp = StaticPages::model()->findByPk($this->pageKey);

		$this->render('index', array('value' => $sp ? $sp->value_ru : ''));
	}

	public function actionUpdate()
	{
		$model = StaticPages::model()->findByPk($this->pageKey);

		if(!$model)
		{
			$model = new StaticPages;
			$model->key = $this->pageKey;
		}

		if(isset($_POST['StaticPages']))
		{
			$model->attributes = $_POST['StaticPages'];
			if($model->save()) $this->redirect(array('index'));
		}

		$this->render('update', array('model' => $model));
	}

	public function filters()
	{
		return array('accessControl');
	}

	public function accessRules()
	{
		return array
		(
			array	('allow', 'actions' => array('index', 'update'), 'users' => array('admin')),
			array('deny', 'users' => array('*'))
		);
	}

}

?>