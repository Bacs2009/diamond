<?php

class FooterLinksController extends Controller
{

	public $layout = 'views/layouts/admin_column2.twig';

	public function actionIndex()
	{
		$model = new FooterLinks('search');

		$model->unsetAttributes();
		if(isset($_GET['FooterLinks'])) $model->attributes = $_GET['FooterLinks'];

		$this->render('index', array('model' => $model));
	}

	public function actionCreate()
	{
		$model = new FooterLinks;

		if(isset($_POST['FooterLinks']))
		{
			$model->attributes = $_POST['FooterLinks'];
			if($model->save()) $this->redirect(array('index'));
		}

		$this->render('create', array('model' => $model));
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		if(isset($_POST['FooterLinks']))
		{
			$model->attributes = $_POST['FooterLinks'];
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

	public function actionMove()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			if(isset($_GET['id']) && isset($_GET['direction']))
			{
				$model = FooterLinks::model()->findByPk((int) $_GET['id']);

				$direction = (int) $_GET['direction'] == 1 ? 1 : -1;

				$model2 = FooterLinks::model()->findByAttributes(array('orders' => $model->orders + $direction));

				if($model && $model2)
				{
					$model2->orders = $model->orders;
					$model2->save(false);

					$model->orders = $model->orders + $direction;
					$model->save(false);
				}
			}
		}

		Yii::app()->end();
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
		$model = FooterLinks::model()->findByPk($id);
		if($model === null) throw new CHttpException(404, 'The requested page does not exist.');

		return $model;
	}

}

?>