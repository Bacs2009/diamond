<?php

class MobileController extends Controller
{


  public $layout = 'views/layouts/mobile.twig';

  public function actionIndex()
  {
    $collections = Collection::model()->getAll();
    $meta_info = Menu::model()->get_meta('',Yii::app()->params->language);
    $this->render('index', array('collections' => $collections, 'meta_info'=>$meta_info));
  }
  
  public function actionAwards()
  {
    $this->render('awards');
  }
  
  public function actionService()
  {
    $this->render('service');
  }
  
  public function actionOther()
  {
    $this->render('other');
  }
  
  public function actionAbout()
  {
    $this->render('about');
  }
  
  public function actionCont()
  {
    $this->render('cont');
  }
  
  public function actionMonarhiya()
  {
    $_GET['collection_id'] = 8;
    $content = Ring::model()->getRings($_GET['collection_id']);
    
   
    $this->render('readmore', array('content' => $content));
  }
  
  public function actionLucklovelife()
  {
    $_GET['collection_id'] = 12;
    $content = Ring::model()->getRings($_GET['collection_id']);
  
     
    $this->render('readmore', array('content' => $content));
  }
  
  public function actionPomolvochnye()
  {
    $_GET['collection_id'] = 17;
    $content = Ring::model()->getRings($_GET['collection_id']);
    
    /*$arr_str = explode(" ", $content[0]['name_ru']);
    $arr = array_slice($arr_str, 2, 2);
    $content[0]['name_ru'] = implode(" ", $arr);
     */
    $this->render('readmore', array('content' => $content));
  }
  
  public function actionRay()
  {
    $_GET['collection_id'] = 10;
    $content = Ring::model()->getRings($_GET['collection_id']);
  
     
    $this->render('readmore', array('content' => $content));
  }
  
  public function actionHraniteli()
  {
    $_GET['collection_id'] = 6;
    $content = Ring::model()->getRings($_GET['collection_id']);
  
     
    $this->render('readmore', array('content' => $content));
  }
  
  public function actionFaeton()
  {
    $_GET['collection_id'] = 5;
    $content = Ring::model()->getRings($_GET['collection_id']);
  
     
    $this->render('readmore', array('content' => $content));
  }
  
  public function actionNovoozarennye()
  {
    $_GET['collection_id'] = 3;
    $content = Ring::model()->getRings($_GET['collection_id']);
  
     
    $this->render('readmore', array('content' => $content));
  }
  
  public function actionNevinnost()
  {
    $_GET['collection_id'] = 2;
    $content = Ring::model()->getRings($_GET['collection_id']);
  
     
    $this->render('readmore', array('content' => $content));
  }
  
  public function actionGranilyubvi()
  {
    $_GET['collection_id'] = 4;
    $content = Ring::model()->getRings($_GET['collection_id']);
  
     
    $this->render('readmore', array('content' => $content));
  }
  
  public function actionSolovey()
  {
    $_GET['collection_id'] = 11;
    $content = Ring::model()->getRings($_GET['collection_id']);
  
     
    $this->render('readmore', array('content' => $content));
  }
  
  public function actionSoglasie()
  {
    $_GET['collection_id'] = 1;
    $content = Ring::model()->getRings($_GET['collection_id']);
  
     
    $this->render('readmore', array('content' => $content));
  }
  
  public function actionHepipipl()
  {
    $this->redirect('http://stdiamond.ua/wedding_rings/happypeople#/1');
  }
  
  public function actionSearch(){
    $content = '';
    function array_chunk_vertical($input, $size, $preserve_keys = false, $size_is_horizontal = true){
      $chunks = array();
      if ($size_is_horizontal) { $chunk_count = ceil(count($input) / $size); }
      else {$chunk_count = $size; }
      for ($chunk_index = 0; $chunk_index < $chunk_count; $chunk_index++) {  $chunks[] = array(); }
      $chunk_index = 0;
      foreach ($input as $key => $value){
        if ($preserve_keys) { $chunks[$chunk_index][$key] = $value;}
        else {$chunks[$chunk_index][] = $value;}
        if (++$chunk_index == $chunk_count) {$chunk_index = 0;}
      }
      return $chunks;
    }
    //		if(Yii::app()->language == 'uk_UA'){$lang = 'ua';}elseif(Yii::app()->language == 'en_GB'){$lang='en'}else{ $lang='ru'; }
    $lang = Yii::app()->params->language;
    $session=new CHttpSession;
    $session->open();
    $session['search'] = $_GET['search'] ? $_GET['search'] : $session['search'];
    //$_SESSION['search'] =  $_GET['search'] ? $_GET['search'] : $_SESSION['search'];
    $filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
    $cost = isset($_GET['cost']) ? $_GET['cost'] : 'DESC';
    $content = Ring::model()->sitesearch($session['search'], $filter, $cost,$lang);
  
    if(count($content) > 0){
      $content = array_chunk_vertical($content,4,false,false);
    }
    //print_r($content);
    //print_r(count($content[0]));
    $this->render('search', array('content' => $content, 'search_count' => count($content[0])+count($content[1])+count($content[2])+count($content[3]),'filter' => $filter,'cost'=>$cost));
  }
  
}