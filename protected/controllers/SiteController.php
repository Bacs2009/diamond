<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page' => array('class' => 'CViewAction'	)
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
 public function actionIndex() {
   
   
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $collections = Collection::model()->getAll();
        $actions = Actions::model()->getForMain(Yii::app()->params->language);
        //echo var_dump($actions);
//         echo "<br /><br /><br /><br /><br />";
//         foreach ($actions as $keys => $values){
//           //echo $v."<br />";
//           foreach ($values as $key => $val) {
//             echo $key.'<=======>'.$val."<br />"; 
//           }
//         }
        /*$clip = Clips::model()->getStickyHome();

        $cookieCity = Yii::app()->request->cookies['city'] ? (int)Yii::app()->request->cookies['city']->value : 1;
        Yii::app()->request->cookies['city'] = new CHttpCookie('city', $cookieCity, array('expire' => time() + 30 * 24 * 60 * 60));
        $cityId = $cookieCity ? $cookieCity : '1';

        $hallCity = CHtml::listData(HallCity::model()->getCitiesForMain(), 'id', 'City');

        $events = Events::model()->getEventsForMain($cityId);

        $schedule = SpecialSchedule::model()->getWeekSchedule(14);

        $countDown = CountDown::model()->getLatest();

        $stars = Stars::model()->get9Random();

				$clips = Clips::model()->getForMain();
*/      
        $meta_info = Menu::model()->get_meta('',Yii::app()->params->language);
        
//print_r($collections);
        $this->render('index', array(
            'collections' => $collections,
            'actions' => $actions,
            'offers_count' => count($actions),
       //     'news' => $news,
       //     'events' => $events,
       //     'hallCity' => $hallCity,
       //     'selectedCity' => $cityId,
       //     'schedule' => $schedule,
       //     'countDown' => $countDown,
       //     'stars' => $stars,
       //     'clips' => $clips,
            'meta' => $meta_info
        ));
        
    }

	 /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
            {
            		if($error['code'] == 404)
            		{
            			$this->layout = 'views/layouts/service.twig';
                	$this->render('errors/404', $error);
                }
                else $this->render('errors/other', $error);
            }
        }
    }

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				//$this->redirect(Yii::app()->user->returnUrl);
			$this->redirect('/admin/main');
		}
		// display the login form
$this->layout = 'views/layouts/service.twig';
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

public function actionGetcollections(){
		$collections = Collection::model()->getAll();
		$to_display = '';
		foreach($collections as $coll){
		 if($_GET['lang'] != 'ru'){		
$lang = $_GET['lang']."/";
		 }else{
		 	$lang = '';
		 }
			$to_display .= '<a href="/'.$lang.'#/colection/'.$coll['name_ru'].'"><img src="'.$coll->imageUrl['forMain'].'" alt="">'.$coll["name_".$_GET['lang']].'</a>';
		}
		/*if($_GET['lang'] == 'ru'){
		$to_display .= '<a href="http://stdiamond.ua/"><img src="http://jewelrybazaar.com/images/11_preview.png" alt="">Украшения</a>';
		}
		else if($_GET['lang'] == 'ua')
		{
		$to_display .= '<a href="http://stdiamond.ua/"><img src="http://jewelrybazaar.com/images/11_preview.png" alt="">Прикраси</a>';
		}
		*/
		echo $to_display;
	}
	
}

?>