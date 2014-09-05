<?php

class ActionsController extends Controller
{

	public $layout = 'views/layouts/admin_column2.twig';

	public function actionIndex()
	{
		$model = new Actions('search');

		$model->unsetAttributes();
		if(isset($_GET['Actions'])) $model->attributes = $_GET['Actions'];

		$this->render('index', array('model' => $model));
	}

	public function actionCreate()
	{
		$model = new Actions;

		if(isset($_POST['Actions']))
		{
			$model->attributes = $_POST['Actions'];
			if($model->save()) $this->redirect(array('index'));
		}

		$this->render('create', array('model' => $model));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		if(isset($_POST['Actions']))
		{
			$model->attributes = $_POST['Actions'];
			if($model->save()) $this->redirect(array('index'));
		}

		$this->render('update', array('model' => $model));
	}

	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		if(!isset($_GET['ajax']))
		{
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
	}

	public function filters()
	{
		return array('accessControl');
	}

	public function accessRules()
	{
		return array
		(
			array	('allow', 'actions' => array('index', 'create', 'update', 'delete', 'move'), 'users' => array('admin')),
			array('deny', 'users' => array('*'))
		);
	}

	public function loadModel($id)
	{
		$model = Actions::model()->findByPk($id);
		if($model === null) throw new CHttpException(404, 'The requested page does not exist.');

		return $model;
	}

}

?>