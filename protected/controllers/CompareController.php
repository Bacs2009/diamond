<?php

class CompareController extends Controller
{

	public function actionIndex()
	{
	//	$content = StaticPages::model()->findByPk('about');
		if(Yii::app()->language == 'uk_UA'){$lang = 'ua';}else{ $lang='ru'; }
		$session=new CHttpSession;
  		$session->open();
		
		$ids_test = split(';',$session['compare']);
		$ids = Array();
		foreach($ids_test as $val){
			$ids[] = str_replace('!','',$val);
		}
		//print_r($ids);
		$all_list = Ring::model()->getRingsByIds($ids,$lang);
		$this->render('index', array('list_compare'=>$all_list,'compare_count'=>count(split(';',$session['compare']))-1));
	}

	public function actionAddtocompare(){
		$session=new CHttpSession;
  		$session->open();
		//echo $session['compare'];
  		//$session['compare']=$value;
        if(!isset($session['compare'])){
	  		$session['compare']='';
	  	}
		//echo $session['compare'];
	   if(!strstr($session['compare'],"!".$_GET['id'].";")){
	   	$session['compare'] .= "!".$_GET['id'].";";
	   }
	   //echo $session['compare'];
	  // if(!in_array($_GET['id'],$_SESSION['compare'])){		
	//	$_SESSION['compare'][] = $_GET['id'];
	 //  }
		//echo count($_SESSION['compare']);
		//echo $session['compare'];
		echo count(split(';',$session['compare']))-1;
		#$this -> render('fullinfo',array('rings' => $content));
	}
	
	public function actionRemovecompare(){
	  /*if (($key = array_search($_GET['id'], $_SESSION['compare'])) !== false) {
    	unset($_SESSION['compare'][$key]);
	  }
	  echo count($_SESSION['compare']);
	   * */

	   $session=new CHttpSession;
  		$session->open();
		$session['compare'] = str_replace("!".$_GET['id'].";", '', $session['compare']);
	   echo count(split(';',$session['compare']))-1;
	}
}

?>