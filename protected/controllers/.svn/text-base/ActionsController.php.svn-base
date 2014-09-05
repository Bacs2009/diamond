<?php

class ActionsController extends Controller
{

	public function actionIndex()
	{
		$actions = Actions::model()->getList(Yii::app()->params->language);
		$menuItem = Menu::model()->getItemByUrl(Yii::app()->params->language);
    $temp = split('/',Yii::app()->request->requestUri);
    $meta_info = Menu::model()->get_meta($temp[count($temp)-1],Yii::app()->params->language);
		
		$this->render
		(
			'index',
			array
			(
				'actions' => $actions['list'],
				'count' => $actions['count'],
				'moreUrl' => Yii::app()->urlManager->createAbsoluteLanguageUrl('actions/more'),
				'menuItem' => $menuItem,
				'meta' => $meta_info
			)
		);
	}

	public function actionView()
	{
		$action = Actions::model()->findByPk((int) $_GET['id']);

		if(!$action) throw new CHttpException(404, Yii::t('actions', 'Акция не найдена'));

		$menuItem = Menu::model()->getItemByUrl(Yii::app()->params->language);

		$this->render('view', array('action' => $action, 'menuItem' => $menuItem));
	}

	public function actionMore()
	{
		if(isset($_POST['page']) && is_numeric($_POST['page']) && $_POST['page'] > 1)
		{
			$page = (int) $_POST['page'];

			$actions = Actions::model()->getList(Yii::app()->params->language, ($page - 1) * 8);

			$data = array();

			foreach($actions['list'] as $value)
			{
				$data[] = array('title' => $value->getLangProp('title'), 'href' => $value->getUrl(), 'img' => $value->imageUrl['preview']);
			}

			echo json_encode(array('result' => 1, 'data' => array('list' => $data, 'count' => $actions['count'])));
		}
		else
		{
			echo '{"result":0}';
		}

		Yii::app()->end();
	}

	public function filters()
	{
		return array('ajaxOnly + more');
	}

}

?>