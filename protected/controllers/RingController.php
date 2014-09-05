<?php

class RingController extends Controller
{



	public function actionIndex()
	{
		$content = StaticPages::model()->findByPk('about');
		$this->render('index', array('content' => $content ? $content->{'value_' . Yii::app()->language} : ''));
	}

	public function actionGetring(){
	  //echo Yii::app()->language;
	  //$_GET['collection_id'] = Collection::model()->getIdByRemoteId($_GET['collection_id']);
		$content = Ring::model()->getRings($_GET['collection_id']);	
		$collection_name = Collection::model()->findByAttributes(array('remote_id'=>$_GET['collection_id']));
		// /echo $collection_name["name_".$_GET['lang']];
// 		        echo "<br /><br /><br /><br /><br />";
// 		        foreach ($content as $keys => $values){
// 		          //echo $v."<br />";
// 		          foreach ($values as $key => $val) {
// 		            echo $key.'<=======>'.$val."<br />";
// 		          }
// 		        }
		$this -> render('ring',array('rings_in_collection' => $content,'collection_name'=>$collection_name["name_".$_GET['lang']],'language' => $_GET['lang']));
	}
	
	public function actionGetfullinfo(){
	  unset($_SESSION['ring_info_w']);
    unset($_SESSION['ring_info_m']);
		//if(Yii::app()->language == 'uk_UA'){$lang = 'ua';}else{ $lang='ru'; }
    $lang = Yii::app()->params->language;
		$session=new CHttpSession;
  	$session->open();
		$content = Ring::model()->getfullinfo($_GET['ring_id'],$lang);
		$this -> render('fullinfo',array('rings' => $content,'session_compare'=>count(split(';',$session['compare']))-1));
	}
	
	public function actionGetfullinfoMobile(){
	  $ring_w = Ring::model()->getMobile($_GET['ring_id'], $_GET['lang']);
	 
    $this->layout=false;
    header('Content-type: application/json');
    echo json_encode($ring_w);
    Yii::app()->end();
	}
	
	public function actionMetalchanged(){
	  $render = Ring::model()->getProbes($_GET['woman'],$_GET['man'],$_GET['lang'],$_GET['metal_id']);
    $this->layout=false;
    header('Content-type: application/json');
    echo json_encode($render);
    Yii::app()->end(); 
	}
  
  public function actionProbechanged(){
    $render = Ring::model()->getMetals($_GET['woman'],$_GET['man'],$_GET['lang'],$_GET['probe_id']);
    $this->layout=false;
    header('Content-type: application/json');
    echo json_encode($render);
    Yii::app()->end(); 
  }
  
  public function actionRebuildconstructor(){
    $render = Array();
    $render['metals'] = Ring::model()->getMetals($_GET['woman'],$_GET['man'],$_GET['lang']);
    $render['stones'] = Ring::model()->getStones($_GET['woman'],$_GET['man'],$_GET['lang']);
    //$render['stones'] = array('m' => )
    $this->layout=false;
    header('Content-type: application/json');
    echo json_encode($render);
    Yii::app()->end(); 
  }
  
  public function actionGetIdByName(){
    $c = Ring::model()->getidbyname($_GET['lang']);
    $this->layout=false;
    header('Content-type: application/json');
    //print_r($c);
    echo json_encode($c);
    Yii::app()->end(); 
  }
  
  public function actionGetRealIdByName(){
    $c = Ring::model()->getrealidbyname($_GET['name'], $_GET['lang']);
    $this->layout=false;
    header('Content-type: application/json');
    //print_r($content);
    echo json_encode($c);
    Yii::app()->end();
  }
  
	public function actionSendmailsite(){
		$Subject = '=?UTF-8?B?' . base64_encode('STDIAMOND '.$_POST['mail_theme']) . '?=';
			$Header[] = 'From: STDIAMOND <robot@stdiamond.ua>';
      $Header[] = 'Content-type: text/html; charset=utf-8';
			$Header[] = 'To: ' . $_POST['mail_email'];
			$Header[] = 'Reply-To: ' . 'robot@stdiamond.ua';
			$Header[] = 'Mime-Version: 1.0';
			$Header[] = 'Content-Type: text/html;';
			$content = StaticPages::model()->findByPk('letter');
			
			$content = $content ? $content->{'value_' . $_POST['lang']} : '';
		
			$Body = str_replace('[[name]]', $_POST['mail_name'], $content);
			if($_POST['lang'] == 'ua'){
				$lang_add = 'ua/';
}elseif($_POST['lang'] == 'en'){
				$lang_add = 'en/';
			}
			else{
				$lang_add = '';
			}
			$Body = str_replace('[[link_to_ring]]',Yii::app()->params['main_site_url'].$lang_add.'?'.$_POST['mail_link'],$Body);
			$Body = str_replace('[[mail_comment]]',$_POST['mail_comment'],$Body);
			$letter_text = "
  <html>
  <head>
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <title>STDIAMOND</title>
  </head>
  <body bgcolor=\"#FFFFFF\">
  ";
  $letter_text .= $Body."</body></html>";
			mail($_POST['mail_email'], $Subject, $Body, implode("\r\n", $Header) . "\r\n");
			echo 'sended';
	}
	
	public function actionSaveshare(){
		header("Expires: Mon, 25 Jan 1970 05:00:00 GMT");   
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		header("Cache-Control: no-store, no-cache, must-revalidate");  
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");

		$current_dir = getcwd();
		$uploads_dir = $current_dir.'/temp_files/';
		
		foreach ($_FILES as $key => $value) {
           		$old_name = $value['tmp_name'];
				$timer = time();
           		$new_name = $uploads_dir . $timer . '.jpg';
           		move_uploaded_file( $old_name, $new_name);
		};
		if(isset($_POST['network'])){
			$network = $_POST['network'];
			$gid = $_POST['gid'];
			$sid = $_POST['sid'];
			$id = $_POST['id'];
    		// 400 x 400
    	print '{"status": "ok", "fileName": "'.$timer.'.jpg","network":"' . $network . '", "gid":"' . $gid . '", "id":"' . $id . '", "sid":"' . $sid . '","text":"Обручальные кольца STDiamond", "name":"STDiamond"}';
		}
		
	}
	
	
	protected function FileMime($Name)
	{
		$Mimes = array
		(
			'gif'=>'image/gif',
			'png'=>'image/png',
			'jpe'=>'image/jpeg',
			'jpeg'=>'image/jpeg',
			'jpg'=>'image/jpeg'
		);

		if($Name)
		{
			$Name = explode('.', $Name);
			if(sizeof($Name) == 2 && isset($Mimes[strtolower($Name[1])])) return $Mimes[strtolower($Name[1])];
		}

		return 'application/octet-stream';
	}
	
	public function actionSendmail(){
		header("Expires: Mon, 25 Jan 1970 05:00:00 GMT");   
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
		header("Cache-Control: no-store, no-cache, must-revalidate");  
		header("Cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		$current_dir = getcwd();
		$uploads_dir = $current_dir.'/temp_files/';
//$uploads_dir = '/Users/pashab/work/fileLoader/bin/';

		if(isset($_POST['mail'])){
			$mail = $_POST['mail'];
			$name = $_POST['name'];
			$subject = $_POST['subject'];
			$message = "<p>".$_POST['message']."</p>";
    		foreach ($_FILES as $key => $value) {
           		$old_name = $value['tmp_name'];
           		$new_name = $uploads_dir . time(). '.jpg';
           		move_uploaded_file( $old_name, $new_name);
			};
			
			$Boundary = strtoupper(uniqid(time()));

			
			$Subject = '=?UTF-8?B?' . base64_encode('Примерочная '.$subject) . '?=';
			$Header[] = 'From: STDIAMOND <robot@stdiamond.ua>';
			$Header[] = 'To: ' . $mail;
      //$Header[] = 'Content-type: text/html; charset=utf-8';
			$Header[] = 'Reply-To: ' . 'robot@stdiamond.ua';
			$Header[] = 'Mime-Version: 1.0';
			$Header[] = 'Content-Type: multipart/mixed;';
			$Header[] = ' boundary="' . $Boundary . '"' . "\r\n";

			$Attach = '--' . $Boundary . "\r\n";
			$Attach .= 'Content-Type: ' . $this->FileMime(basename($new_name)) . ';';
			$Attach .= 'name="' . basename($new_name) . '"' . "\r\n";
			$Attach .= 'Content-Transfer-Encoding: base64' . "\r\n";
			$Attach .= 'Content-Disposition: attachment;';
			$Attach .= 'filename="' . basename($new_name) . '"' . "\r\n\r\n";
			$Attach .= chunk_split(base64_encode(file_get_contents($new_name))) . "\r\n";
				
			$Body = '--' . $Boundary . "\r\n";
			$Body .= 'Content-Type: text/html; charset=utf-8' . "\r\n";
			$Body .= 'Content-Transfer-Encoding: 8bit' . "\r\n\r\n" . $message . "\r\n\r\n";
			$Body .= $Attach;

			mail($mail, $Subject, $Body, implode("\r\n", $Header) . "\r\n");
	  	print "{'status': 'ok', 'log':' mail=" .$mail . ", name=" . $name . ", subject=" . $subject . ", message=" . $message . "'}";
		}
	}
	
	
	public function actionCollectionslist(){

		echo '[{"id":12, "title":"Luck.Love.Life."}]';
	}
	
	public function actionFlashitems(){
		$content = Ring::model()->getRingsCollection(12);
    
		$to_show = "[";
		$current_dir = getcwd();
		foreach($content as $val){
			// /echo '/home/s.reinhold/www/rings_dev/images/flash_rings/img/'.$val['article'].'.png';
		if(is_file($current_dir.'/images/flash_rings/img/'.$val['articul'].'.png')){
			
		$to_show .= ' {
			"id": "'.$val['id'].'", 
        	"sid": "'.$val['id'].'", 
        	"title": "'.$val['name_ru'].'", 
        	"image": "/images/flash_rings/img/'.$val['articul'].'.png" 
    		},';
		}
	}
		$to_show = substr($to_show, 0,-1);
		$to_show .= "]";
		echo $to_show;
	}
	
	public function actionSearch(){
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

  public function actionChangeprice(){
	  $ring_info = array();
    if(isset($_SESSION['ring_info_w']['selected_size'])){
      $prev_size_w = $_SESSION['ring_info_w']['selected_size'];
    }
    if(isset($_SESSION['ring_info_m']['selected_size'])){
      $prev_size_m = $_SESSION['ring_info_m']['selected_size'];
    }
   unset($_SESSION['ring_info_w']);
   unset($_SESSION['ring_info_m']);
   $new_pricer = Array();
   $lang = $_POST['lang'];
   
   if(isset($_POST['man']) && $_POST['man'] != '0'){
    unset($ring_info_w);
    unset($ring_info_m);
    $metal = $_POST['metal_m'];
    $probe = $_POST['probe_m'];
    $surface = $_POST['surface_m'];
    $enamel = $_POST['enamel_m'];
    $stone_type = $_POST['stone_type_m'];
    
    $size_m = $_POST['size_m'];
    $ring_m = Ring::model()->findByPk($_POST['man']);
    if(!isset($prev_size_m)){
      $prev_size_m = $ring_m->size;
    }
   // print_r($collection); die;
    $ring_info = $this->get_all_info_original($_POST['man']);
    $ring_info['selected_size'] = $size_m;

    $selected_surface = Surface::model()->findByPk($_POST['surface_m']);
    $ring_info['selected_surface'] = array('id' => $selected_surface->id,'name_ua'=>$selected_surface->name_ua,'name_ru' => $selected_surface->name_ru);
    
    $selected_enamel = Enamel::model()->findByPk($_POST['enamel_m']);
    $ring_info['selected_enamel'] = array('id' => $selected_enamel->id,'name_ua'=>$selected_enamel->name_ua,'name_ru' => $selected_enamel->name_ru);
    
    if($_POST['metal_m'] != ''){
      $sql = "SELECT * FROM metal WHERE probe='".(int)$_POST['probe_m']."' AND CONCAT(name_short,name_$lang) = '".$_POST['metal_m']."'";
     // echo $sql;
      $metal = Yii::app()->db->createCommand($sql)->queryRow();
      $ring_info['selected_metal'] = array('metal_name' => $_POST['metal_m'], 'probe' => $_POST['probe_m'],'id'=>$metal['id'],'name_ua'=>$metal['name_ua'], 'name_ru' => $metal['name_ru'],'name_short' => $metal['name_short'],'probe'=>$metal['probe']);
    }else{
      $ring_info['selected_metal'] = array();
    }
    $stone_type = $_POST['stone_type_m'];
    //echo count($ring_m->stones);
    if(count($ring_m->stones) > 0 && $stone_type != ''){
     
      foreach($ring_m->stones as $val){
      // $sql = "Select * from stones where stone_type_id = $stone_type and size ='".$val->stones->size."'";
      $sql = "Select * from stones where stone_type_id = 1 and color_ru = '$stone_type' and size ='".$val->stones->size."' and karatnost='".$val->stones->karatnost."'";
        
       $st = Yii::app()->db->createCommand($sql)->queryAll();
       $i = 0;
       foreach($st as $val1){
        // print_r($val1);
        $ring_info['selected_stones']['size']["try_size_".$val->stones->size]["stone_$i"] = array('id' => $val1['id'],
                                                      'count' => $val['count'],
                                                      'name_ua'=>$val1['name_ua'],
                                                      'name_ru'=>$val1['name_ru'],
                                                      'karatnost' => $val1['karatnost'],
                                                      'price' => $val1['price'],
                                                      'stone_size' => $val1['size'],
                                                      'size_dimention' => $val1['size_dimention'],
                                                      'ogranka' => $val1['ogranka'],
                                                      'naturalnost' => $val1['naturalnost'],
                                                      'color_ru' => $val1['color_ru'],
                                                      'color_ua' => $val1['color_ua'],
                                                      'remote_id' => $val1['remote_id']);
                                                      
        $ring_info['stones_to_order']["stone_$i"] = $val1['id'];
        $i++;
       }
      }

    }else{
      $ring_info['selected_stones'] = array();
    }
    
    

    $_SESSION['ring_info_m'] = $ring_info;
	  $ring_info_m = $ring_info;
  // /  echo $ring_info['ring_original']['collection']['formula']; die;

    if($_POST['surface_m'] != '' || $_POST['enamel_m'] != '' || $_POST['metal_m'] != '' || $_POST['stone_type_m'] != '' || $_POST['size_m'] != $prev_size_m){
     eval($ring_info_m['ring_original']['collection']['formula']);
     $new_pricer['m'] = $new_price_m;
    }
    
   }
   if(isset($_POST['woman']) && $_POST['woman'] != '0'){
    unset($ring_info_w);
    unset($ring_info_m);
    $metal = $_POST['metal_w'];
    $probe = $_POST['probe_w'];
    $surface = $_POST['surface_w'];
    $enamel = $_POST['enamel_w'];
    $stone_type = $_POST['stone_type_w'];
    
     
     
    $size_w = $_POST['size_w'];
    $ring_w = Ring::model()->findByPk($_POST['woman']);
    if(!isset($prev_size_w)){
      $prev_size_w = $ring_w->size;
    }
   // print_r($collection); die;
    $ring_info = $this->get_all_info_original($_POST['woman']);
    $ring_info['selected_size'] = $size_w;

    $selected_surface = Surface::model()->findByPk($_POST['surface_w']);
    $ring_info['selected_surface'] = array('id' => $selected_surface->id,'name_ua'=>$selected_surface->name_ua,'name_ru' => $selected_surface->name_ru);
    
    $selected_enamel = Enamel::model()->findByPk($_POST['enamel_w']);
    $ring_info['selected_enamel'] = array('id' => $selected_enamel->id,'name_ua'=>$selected_enamel->name_ua,'name_ru' => $selected_enamel->name_ru);
    
    if($_POST['metal_w'] != ''){
      $sql = "SELECT * FROM metal WHERE probe='".(int)$_POST['probe_w']."' AND CONCAT(name_short,name_$lang) = '".$_POST['metal_w']."'";
     // echo $sql;
      $metal = Yii::app()->db->createCommand($sql)->queryRow();
      $ring_info['selected_metal'] = array('metal_name' => $_POST['metal_w'], 'probe' => $_POST['probe_w'],'id'=>$metal['id'],'name_ua'=>$metal['name_ua'], 'name_ru' => $metal['name_ru'],'name_short' => $metal['name_short'],'probe'=>$metal['probe']);
    }else{
      $ring_info['selected_metal'] = array();
    }
    $stone_type = $_POST['stone_type_w'];
    //echo count($ring_m->stones);
   
    if(count($ring_w->stones) > 0 && $stone_type != ''){
     
      foreach($ring_w->stones as $val){
      // $sql = "Select * from stones where stone_type_id = $stone_type and size ='".$val->stones->size."'";
      $sql = "Select * from stones where stone_type_id = 1 and color_ru = '$stone_type' and size ='".$val->stones->size."' and karatnost='".$val->stones->karatnost."'";
       // echo $sql;
       $st = Yii::app()->db->createCommand($sql)->queryAll();
       $i = 0;
       foreach($st as $val1){
        // print_r($val1);
        $ring_info['selected_stones']['size']["try_size_".$val->stones->size]["stone_$i"] = array('id' => $val1['id'],
                                                      'count' => $val['count'],
                                                      'name_ua'=>$val1['name_ua'],
                                                      'name_ru'=>$val1['name_ru'],
                                                      'karatnost' => $val1['karatnost'],
                                                      'price' => $val1['price'],
                                                      'stone_size' => $val1['size'],
                                                      'size_dimention' => $val1['size_dimention'],
                                                      'ogranka' => $val1['ogranka'],
                                                      'naturalnost' => $val1['naturalnost'],
                                                      'color_ru' => $val1['color_ru'],
                                                      'color_ua' => $val1['color_ua'],
                                                      'remote_id' => $val1['remote_id']);
        $ring_info['stones_to_order']["stone_$i"] = $val1['id'];
        $i++;
       }
      }

    }else{
      $ring_info['selected_stones'] = array();
    }
   // print_r($ring_info);
   $ring_info_w = $ring_info;
    $_SESSION['ring_info_w'] = $ring_info;
    if($_POST['surface_w'] != '' || $_POST['enamel_w'] != '' || $_POST['metal_w'] != '' || $_POST['stone_type_w'] != '' || $_POST['size_w'] != $prev_size_w){
      eval($ring_info_w['ring_original']['collection']['formula']);
      $new_pricer['w'] = $new_price_w;
    }
    //$formula = '$new_price = ($site_price - $metall_price)+$rand + ((($metal_weight * (int)$size_new)/(int)$ring_size))*$KM*$C*$KN;';
    //eval($ring_info['ring_original']['collection']['formula']);
    
    //$new_pricer['w'] = $new_price;
   
   }
  // print_r($ring_info_w);
   //echo($new_pricer['w']); 
    $this->layout=false;
    //print_r($_SESSION['ring_info_w']['selected_stones']);
    header('Content-type: application/json');
    echo json_encode($new_pricer);
    Yii::app()->end(); 
  }

	public function actionFormula(){
		$ring_info = Ring::model()->findByPk($_POST['id']);
		$site_price = $ring_info['price'];
		$metall_price = 7;
		$metal_weight = 3;
		$size_new = str_replace(',','.',$_POST['size']);
		$ring_size = str_replace(',','.',$ring_info['size']); // from ring	
		$KM = 2;
		$C = 9;
		$KN = 3;
    $rand = rand(100, 300);
		$formula = '$new_price = ($site_price - $metall_price)+$rand + ((($metal_weight * (int)$size_new)/(int)$ring_size))*$KM*$C*$KN;';
		eval($formula);
		echo $new_price;
	}
	
  
	public function actionSendorder(){
		$order_size_m = $_POST['order_size_m'];
		$order_size_w = $_POST['order_size_w'];
		$order_ring_m = $_POST['order_ring_m'];
		$order_ring_w = $_POST['order_ring_w'];
		$order_price_m = $_POST['order_price_m'];
		$order_price_w = $_POST['order_price_w'];
		$order_name = $_POST['order_name'];
		$order_email = $_POST['order_email'];
		$order_city = $_POST['order_city'];
		$order_phone = $_POST['order_phone'];
		$order_comment = $_POST['order_comment'];
		$order_price_m = $_POST['order_price_m'];
		$order_price_w = $_POST['order_price_w'];
		$order_price_btc_m = $_POST['order_price_btc_m'];
		$order_price_btc_w = $_POST['order_price_btc_w'];
		
		
		//$sql = "Insert into orders (name,email,phone,comment,is_sync) values ('".$order_name."','".$order_email."','".$order_phone."','".$order_comment."','".false."')";
		//echo $sql;
		$is_happy = false;
		if($order_size_m != ''){
      $ring_info_m = Ring::model()->findByPk($order_ring_m);
      $collection = Collection::model()->getIdByRemoteId_inner($ring_info_m->collection_id);
      if($collection['id'] == 9){
        $is_happy = true;
      }
    }
    if($order_size_w != ''){
      $ring_info_w = Ring::model()->findByPk($order_ring_w);
      $collection = Collection::model()->getIdByRemoteId_inner($ring_info_w->collection_id);
      if($collection['id'] == 9){
        $is_happy = true;
      }
    }
    //echo $xml->saveXML();die;
		//mail to user
		
		
		
		
		if($is_happy){
		  $Subject = '=?UTF-8?B?' . base64_encode('Регистрация в проекте Новая Семья').'?=';
      $Header[] = 'From: STDIAMOND <robot@stdiamond.ua>';
      $Header[] = 'To: ' . $order_email;
      $Header[] = 'Content-type: text/html; charset=utf-8';
      $Header[] = 'Reply-To: ' . 'robot@stdiamond.ua';
      $Header[] = 'Mime-Version: 1.0';
      $Header[] = 'Content-Type: text/html;';
      $Body = "<html><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8' /></head><body>";
      
      $content = StaticPages::model()->findByPk('ohletter');
      $Body = $content ? $content->{'value_' . $_POST['lang']} : '';
      $Body .= "</body></html>";
		}else{
			$Subject = '=?UTF-8?B?' . base64_encode('STDIAMOND Ваш заказ с сайта').'?=';
			$Header[] = 'From: STDIAMOND <robot@stdiamond.ua>';
			$Header[] = 'To: ' . $order_email;
      $Header[] = 'Content-type: text/html; charset=utf-8';
			$Header[] = 'Reply-To: ' . 'robot@stdiamond.ua';
			$Header[] = 'Mime-Version: 1.0';
			$Header[] = 'Content-Type: text/html;';
      $Body = "<html><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8' /></head><body>";
			
      $content = StaticPages::model()->findByPk('oletter');
      $content = $content ? $content->{'value_' . $_POST['lang']} : '';
      
      $Body .= str_replace('[[user_name]]',$order_name,$content);
      $Body = str_replace('[[user_email]]',$order_email,$Body);
      $Body = str_replace('[[user_city]]',$order_city,$Body);
      $Body = str_replace('[[user_phone]]',$order_phone,$Body);
      $Body = str_replace('[[user_comment]]',$order_comment,$Body);
      
			
			//$Body .= "Добрый день, ".$order_name.".<br />";
			//$Body .= "Вы сделали заказ на сайте <a href=".Yii::app()->params['main_site_url'].">STDIAMOND</a><br />";
			//$Body .= "<h2>Детали Вашего заказа:<h2><br />";
			$w_info = '';
			if($order_size_w != ''){
				$w_info .= "<h3>Для нее</h3>";
        $w_info .= '<img alt="" src="'.Yii::app()->params['main_site_url'].'old_images/'.$ring_info_w['articul'].'.png" />';
        $w_info .= '<p>'.$ring_info_w['name_ru'].'<br />';
        $w_info .= 'Состав:<br />';
        $w_info .= $_POST['order_info_w']. "<span style='color: red;'>*</span>";
        $w_info .= "<br /><b>Размер:</b> ".$order_size_w."<br />";
        $w_info .= '<em>арт. '.$ring_info_w['articul'].'</em><br />';
		//if($_POST['order_price_btc_w'] === 0)
		//{
        $w_info .= "<b>Стоимость:</b> ".floor($order_price_w)." $</p>";
		//}
		//else
		//{
		//$w_info .= "<b>Стоимость:</b> ".$order_price_w." BTC</p>";
		//}
			}
			if($order_size_m != ''){
				$w_info .= "<h3>Для него</h3>";
        $w_info .= '<img alt="" src="'.Yii::app()->params['main_site_url'].'old_images/'.$ring_info_m['articul'].'.png" />';
        $w_info .= '<p>'.$ring_info_m['name_ru'].'<br />';
        $w_info .= 'Состав:<br />';
        $w_info .= $_POST['order_info_m'];
        $w_info .= "<br /><b>Размер:</b> ".$order_size_m."<br />";
        $w_info .= '<em>арт. '.$ring_info_m['articul'].'</em><br />';
		//if($_POST['order_price_btc_m'] === 0)
		//{
        $w_info .= "<b>Стоимость:</b> ".floor($order_price_m)." $</p>";
		//}
		//else
		//{
		//$w_info .= "<b>Стоимость:</b> ".$order_price_m." BTC</p>";
		//}
			}
		}
      
      
     
      //order to database and file
      $connection=Yii::app()->db;
    $command=$connection->createCommand();
    $command->insert('orders', array(
        'name' => $order_name,
        'email' => $order_email,
        'phone' => $order_phone,
        'comment' => $order_comment,
        'city' => $order_city,
        'all_info' => $w_info
    ));     
    $last_id = Yii::app()->db->getLastInsertID();
    //$last_id = mysql_insert_id($sql);
    $order_info_all = array(
        'id' => $last_id,
        'name' => $order_name,
        'email' => $order_email,
        'phone' => $order_phone,
        'comment' => $order_comment,
        'city' => $order_city
    );
    if($order_size_m != ''){
      $ring_info_m = Ring::model()->findByPk($order_ring_m);
      if(!isset($_SESSION['ring_info_m'])){
        $_SESSION['ring_info_m'] = $this->get_all_info_original($order_ring_m);
      }
      //$sql = "Insert into order_info (order_id,metall_id,stones_id,enamel_id,surface_id,size,ring_id,price) values ('".$last_id."','','','','','".$order_size_m."','".$order_ring_m."','".$order_price_m."')";
      $command=$connection->createCommand();
      $ring_m = Ring::model()->findByPk($order_ring_m);
      if(isset($_SESSION['ring_info_m']['selected_metal']['id'])){
        $metal = $_SESSION['ring_info_m']['selected_metal']['id'];
      }else{
        $metal = $ring_m->metal_id;
      }
      if(isset($_SESSION['ring_info_m']['selected_enamel']['id'])){
        $enamel = $_SESSION['ring_info_m']['selected_enamel']['id'];
      }else{
        $enamel = $ring_m->enamel_id;
      }
      if(isset($_SESSION['ring_info_m']['selected_surface']['id'])){
        $surface = $_SESSION['ring_info_m']['selected_surface']['id'];
      }else{
        $surface = $ring_m->surface_id;
      }
      if(count($_SESSION['ring_info_m']['stones_to_order']) != 0){
        $stones = implode(',',$_SESSION['ring_info_m']['stones_to_order']);
      }else{
        $ids = array();
        foreach($ring_m->stones as $val){
            $ids[] = $val->stones->id;
        }
        $stones = implode(',',$ids);
      }
      $order_info_all['ordered_m'] = $_SESSION['ring_info_m'];
      unset($order_info_all['ordered_m']['ring_original']['collection']['formula']);
      $command->insert('order_info', array(
          'order_id' => $last_id,
          'metall_id' => $metal,
          'stones_id' => $stones,
          'enamel_id' => $enamel,
          'surface_id' => $surface,
          'size' => $order_size_m,
          'ring_id' => $order_ring_m,
          'price' => $order_price_m
      ));
      $order_info_all['ordered_m']['calculated_price'] = $order_price_m;
    } 
    if($order_size_w != ''){
      $ring_info_w = Ring::model()->findByPk($order_ring_w);
      if(!isset($_SESSION['ring_info_w'])){
        $_SESSION['ring_info_w'] = $this->get_all_info_original($order_ring_w);
      }
      //$sql = "Insert into order_items (ring_id,size,article,order_id,price) values ('".$order_ring_w."','".$order_size_w."','','".$last_id."','".$order_price_w."')";
      $command=$connection->createCommand();
       $ring_w = Ring::model()->findByPk($order_ring_w);
      if(isset($_SESSION['ring_info_w']['selected_metal']['id'])){
        $metal = $_SESSION['ring_info_w']['selected_metal']['id'];
      }else{
        $metal = $ring_w->metal_id;
      }
      if(isset($_SESSION['ring_info_w']['selected_enamel']['id'])){
        $enamel = $_SESSION['ring_info_w']['selected_enamel']['id'];
      }else{
        $enamel = $ring_w->enamel_id;
      }
      if(isset($_SESSION['ring_info_w']['selected_surface']['id'])){
        $surface = $_SESSION['ring_info_w']['selected_surface']['id'];
      }else{
        $surface = $ring_w->surface_id;
      }
      if(count($_SESSION['ring_info_w']['stones_to_order']) != 0){
        $stones = implode(',',$_SESSION['ring_info_w']['stones_to_order']);
      }else{
        $ids = array();
        foreach($ring_w->stones as $val){
            $ids[] = $val->stones->id;
        }
        $stones = implode(',',$ids);
      }
      $order_info_all['ordered_w'] = $_SESSION['ring_info_w'];
      unset($order_info_all['ordered_w']['ring_original']['collection']['formula']);
      $command->insert('order_info', array(
          'order_id' => $last_id,
          'metall_id' => $metal,
          'stones_id' => $stones,
          'enamel_id' => $enamel,
          'surface_id' => $surface,
          'size' => $order_size_w,
          'ring_id' => $order_ring_w,
          'price' => $order_price_w
      ));
      $order_info_all['ordered_w']['calculated_price'] = $order_price_w;
    }

    
    
    require_once('./array_to_xml.php');
    //print_r($order_info_all);
    $xml = Array2XML::createXML('order', $order_info_all);
    file_put_contents ( "./orders/order_$last_id.xml" , $xml->saveXML() );
    
    //end of order to database
      
      
      if(!$is_happy){
  			$Body = str_replace('[[rings_info]]',$w_info,$Body);
  			$Body = str_replace('[[price_ua]]',(int)$order_price_w+(int)$order_price_m, $Body);
        $Body = str_replace('[[price_usd]]',(int)(((int)$order_price_w+(int)$order_price_m)), $Body);
  			$Body .= "</body></html>";
        //print_r($Body); die;
      }
			mail($order_email, $Subject, $Body, implode("\r\n", $Header) . "\r\n");
			
		//mail to admin
			unset($Header);
			$Header = array();
      if($is_happy){
        $Subject = '=?UTF-8?B?' . base64_encode('STDIAMOND -- Новая заявка на хепипипл') . '?=';
      }else{
			  $Subject = '=?UTF-8?B?' . base64_encode('STDIAMOND -- Новый заказ с сайта') . '?=';
      }
			$Header[] = 'From: STDIAMOND <robot@stdiamond.ua>';
      $Header[] = 'Content-type: text/html; charset=utf-8';
			$Header[] = 'To: ' . 'eco-boutique@diamond.ua';
			$Header[] = 'Reply-To: ' . 'robot@stdiamond.ua';
			$Header[] = 'Mime-Version: 1.0';
			$Header[] = 'Content-Type: text/html;';
			
			$Body = "<html><head><meta http-equiv='Content-Type' content='text/html; charset=utf-8' /></head><body>";
			if($is_happy){
			  $Body .= "Добрый день, поступила новая заявка с сайта<br />";
      }else{
			  $Body .= "Добрый день, поступил новый заказ с сайта<br />";
      }
			$Body .= "<h2>Детали заказа:</h2><br />";
			$Body .= "<b>ID заказа:</b>".$last_id."<br />";
			$Body .= "<b>Имя:</b>".$order_name."<br />";
			$Body .= "<b>Email:</b>".$order_email."<br />";
      $Body .= "<b>Город:</b>".$order_city."<br />";
			$Body .= "<b>Телефон:</b>".$order_phone."<br />";
			$Body .= "<b>Комментарий:</b>".$order_comment."<br /><br />";
			if($order_price_w != ''){
        $Body .= "<h3>Для нее</h3>";
        $Body .= '<img src="'.Yii::app()->params['main_site_url'].'old_images/'.$ring_info_w['articul'].'.png" />';
        $Body .= '<p>'.$ring_info_w['name_ru'].'<br />';
        $Body .= 'Состав:<br />';
        $Body .= $_POST['order_info_w'];
        $Body .= "<br /><b>Размер:</b> ".$order_size_w."<br />";
        $Body .= '<em>арт. '.$ring_info_w['articul'].'</em><br />';
        $Body .= "<b>Стоимость:</b> ".floor($order_price_w)."</p>";
      }
      if($order_price_m != ''){
        $Body .= "<h3>Для него</h3>";
        $Body .= '<img alt="" src="'.Yii::app()->params['main_site_url'].'old_images/'.$ring_info_m['articul'].'.png" />';
        $Body .= '<p>'.$ring_info_m['name_ru'].'<br />';
        $Body .= 'Состав:<br />';
        $Body .= $_POST['order_info_m'];
        $Body .= "<br /><b>Размер:</b> ".$order_size_m."<br />";
        $Body .= '<em>арт. '.$ring_info_m['articul'].'</em><br />';
        $Body .= "<b>Стоимость:</b> ".floor($order_price_m)."</p>";
      }

      $Body .= "</body></html>"; 
		//	mail('s.reinhold@studio7.ua', $Subject, $Body, implode("\r\n", $Header) . "\r\n");
			
      
      unset($Header);
      $Header = array();
      $Header[] = 'From: STDIAMOND <robot@stdiamond.ua>';
      $Header[] = 'Content-type: text/html; charset=utf-8';
      $Header[] = 'To: ' . 'a.badina@studio7.com.ua';
      $Header[] = 'Reply-To: ' . 'robot@stdiamond.ua';
      $Header[] = 'Mime-Version: 1.0';
      $Header[] = 'Content-Type: text/html;';
     // mail('a.badina@studio7.com.ua', $Subject, $Body, implode("\r\n", $Header) . "\r\n");
      
			unset($Header);
			$Header = array();
			$Header[] = 'From: STDIAMOND <robot@stdiamond.ua>';
      $Header[] = 'Content-type: text/html; charset=utf-8';
			$Header[] = 'To: ' . 'eco-boutique@diamond.ua';
			$Header[] = 'Reply-To: ' . 'robot@stdiamond.ua';
			$Header[] = 'Mime-Version: 1.0';
			$Header[] = 'Content-Type: text/html;';
			mail('eco-boutique@diamond.ua', $Subject, $Body, implode("\r\n", $Header) . "\r\n");
			
		echo 'ok';	
	}
	public function get_all_info_original($ring_id){
	  $ring_w = Ring::model()->findByPk($ring_id);
    $collection = Collection::model()->getIdByRemoteId_inner($ring_w->collection_id);
    $surface = Surface::model()->findByPk($ring_w->surface_id);
    $ring_info = array(
    'ring_original' => array('name_ru' => $ring_w->name_ru,
                             'name_ua' => $ring_w->name_ua,
                             'articul' => $ring_w->articul,
                             'size' => $ring_w->size,
                             'gender' => $ring_w->gender,
                             'width' => $ring_w->width,
                             'height' => $ring_w->height,
                             'koeff' => $ring_w->koeff,
                             'weight'=>$ring_w->weight,
                             'thickness' => $ring_w->thickness,
                             'price' => $ring_w->price,
                             'remote_id' => $ring_w->remote_id,
                             'active_st_size' => $ring_w->active_st_size,
                             'collection' => array('id'=>$collection['id'],
                                                   'id_for_ring' => $collection['remote_id'],
                                                   'name_ua' => $collection['name_ua'],
                                                   'name_ru'=>$collection['name_ru'],
                                                   'formula' => $collection['formula']
                                                   ),
                              'metal' => array('id' => $ring_w->metal_id,
                                               'name_ua' => $ring_w->metal->name_ua,
                                               'name_ru' => $ring_w->metal->name_ru,
                                               'name_short' => $ring_w->metal->name_short,
                                               'probe' => $ring_w->metal->probe),
                              'surface' => array('id' => $ring_w->surface_id,
                                                 'name_ua' => $surface->name_ua,
                                                 'name_ru' => $surface->name_ru),
                              'enamel' => array('id' => $ring_w->enamel_id,
                                                 'name_ua' => $ring_w->enamel->name_ua,
                                                 'name_ru' => $ring_w->enamel->name_ru)
                               )
                               
    );
    $i = 0;
    foreach($ring_w->stones as $val){
      $ring_info['ring_original']['stones']["stone_$i"] = array('id' => $val->stones->id,
                                                      'count'=>$val['count'],
                                                      'name_ua'=>$val->stones->name_ua,
                                                      'name_ru'=>$val->stones->name_ru,
                                                      'karatnost' => $val->stones->karatnost,
                                                      'price' => $val->stones->price,
                                                      'stone_size' => $val->stones->size,
                                                      'size_dimention' => $val->stones->size_dimention,
                                                      'ogranka' => $val->stones->ogranka,
                                                      'naturalnost' => $val->stones->naturalnost,
                                                      'color_ru' => $val->stones->color_ru,
                                                      'color_ua' => $val->stones->color_ua,
                                                      'remote_id' => $val->stones->remote_id);
                                                      $i++;
    }
//print_r($ring_info);
  return $ring_info;
  }
}
?>