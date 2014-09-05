<?php

/**
 * This is the model class for table "actions".
 *
 * The followings are the available columns in table 'actions':
 * @property string $id
 * @property string $article
 * @property string $collection_id
 * @property string $metal_id
 * @property string $metal_color
 * @property string $size
 * @property string $weight
 * @property string $enaml
 * @property string $gender
 * @property integer $active
 */
class Ring extends CActiveRecord
{
	public $bigImage;
	public $previewImage;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Actions the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'rings';
	}

	public function init()
	{
		
	}

	public function relations()
	{
		return array('metal' => array(self::BELONGS_TO, 'JewelleryMetals', 'metal_id'),
		 'stones' => array(self::HAS_MANY,'StoneToRing','ring_id'),
		 'can_metal' => array(self::HAS_MANY,'RingsCanMetal','ring_id'),
		 'can_stones' => array(self::HAS_MANY,'RingsCanStone','ring_id'),
		 'enamel' => array(self::BELONGS_TO,'Enamel','enamel_id'),
     'surface_type' => array(self::BELONGS_TO,'Surface','surface_id'));
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array
		(
			array('article,collection_id,metal_id,metal_color', 'required', 'message' => '{attribute} не может быть пустым'),
			array('name_ru, name_ua, name_en', 'filter', 'filter' => array($this->arfilters, 'purifyRich')),
			array('onMain, active', 'numerical', 'integerOnly' => true),
			array('title_ru, title_ua, title_en', 'length', 'max' => 100),
			array('bigImage, previewImage', 'file', 'types' => 'png', 'allowEmpty' => true, 'wrongType' => 'Файл <strong>{file}</strong> должен быть в формате <strong>{extensions}</strong>'),
			array('name_ua,name_ru,name_en', 'safe', 'on' => 'search')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array
		(
			'id' => 'ID',
			'name_ru' => 'Название (рус)',
			'name_ua' => 'Название (укр)',
			'name_en' => 'Название (англ)',
			'active' => 'Активна'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('name_ru', $this->title_ru, true);
		$criteria->compare('naem_ua', $this->title_ua, true);
    $criteria->compare('naem_en', $this->title_en, true);

		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => array('defaultOrder' => 'endDate DESC')));
	}

	public function behaviors()
	{
		return array
		(
			'arfilters' => array('class' => 'application.components.Behavior.ARFiltersBehavior'),
			'imageProcessing' => array
			(
				'class' => 'application.components.Behavior.ARImageProcessingBehavior',
				'images' => array
				(
					'big' => array
					(
						'attribute' => 'bigImage',
						'width' => 478,
						'height' => 230,
						'mode' => 'outer',
						'cropH' => 'center',
						'cropV' => 'top',
						'img_type' => 'png'
					),
					'preview' => array
					(
						'attribute' => 'previewImage',
						'width' => 97,
						'height' => 80,
						'mode' => 'outer',
						'cropH' => 'center',
						'cropV' => 'top',
						'img_type' => 'png'
					)
				)
			)
		);
	}

/*	public function beforeSave()
	{
		$this->updateTime = new CDbExpression('NOW()');

		return parent::beforeSave();
	}*/

	public function getUrl()
	{
		return Yii::app()->createAbsoluteUrl('/') . Yii::app()->urlManager->createLanguageUrl('actions/view', array('id' => $this->primaryKey));
//		return Yii::app()->createAbsoluteUrl('actions/view', array('id' => $this->primaryKey));
	}

	public function getList($language, $offset = 0, $limit = 8)
	{
//		$dependency = new CDbCacheDependency('SELECT MAX(updateTime), \'' . $language . '\' lng FROM ' . $this->tableName());

		$dependency = new CDbCacheDependency('SELECT MAX(updateTime) FROM ' . $this->tableName());

		$date = Yii::app()->dateFormatter->format('yyyy-MM-dd kk:mm:ss', time());

		$sql = 'SELECT id, title_' . $language . ', description_' . $language . ' FROM ' . $this->tableName() . ' WHERE active=1 AND startDate<\'' . $date . '\' AND endDate>\'' . $date . '\' ORDER BY startDate DESC LIMIT :offset, :limit';
		$list = $this->cache(600, $dependency)->findAllBySql($sql, array(':offset' => $offset, ':limit' => $limit));

		return $list;
	}

	public function getLangProp($property)
  {
    return $this->{$property . '_' . Yii::app()->params->language};
  }
	
	public function getRingsCollection($collection_id){
		$sql = "Select * from rings where collection_id=$collection_id and gender='f' order by id";
		//echo $sql; die;
		$list = $this -> findAllBySql($sql);
		//print_r($list[0]); die;
		return $list;
	}
	
	public function getRings($collection_id){
		//$sql = "Select c.artw, r.* from weddingrings as c,rings_old as r where c.collection=$collection_id and c.artw=r.article order by r.id";
		$sql = "Select * from rings where (collection_id = $collection_id and gender='f') or (collection_id = $collection_id and gender='m' and pair_id not in (select id from rings where collection_id=$collection_id and gender='f'))  order by id";
		//echo $sql;
		$list = $this -> findAllBySql($sql);
		$new_list = Array();
		$collection_name = Collection::model()->findByAttributes(array('remote_id'=>$_GET['collection_id']));
		foreach($list as $item){
		  //print_r($item);
			if(is_file('./old_images/'.$item['articul'].'.png')){
				$item['name_ua'] = str_ireplace($collection_name['name_ua'].' ', '', $item['name_ua']);
				$item['name_ru'] = str_ireplace($collection_name['name_ru'].' ', '', $item['name_ru']);
        $item['name_en'] = str_ireplace($collection_name['name_en'].' ', '', $item['name_en']);
			 	$new_list[] = $item;
			}
		}
		//print_r($list[0]); die;
		return $new_list;
	}
	
	public function getRingsByIds($ids,$lang){
		$new_ids = array();
		foreach($ids as $val){
			if($val != ''){
				$new_ids[] = "'".$val."'";
			}
		}
		$connection=Yii::app()->db;   // assuming you have configured a "db" connection
		$to_select = implode(',',$new_ids);
		if($to_select == ''){$to_select="'0'";}
		$sql = "Select * from rings as r where r.id in ($to_select) order by r.id";
		$list = $this -> findAllBySql($sql);
		$rings_pairs = Array();
		foreach($list as $val){
			$collection_name = Collection::model()->findByAttributes(array('remote_id'=>$val['collection_id']))->getLangProp('name');
			if($val['gender'] == 'f'){
				if(key_exists($val['pair_id'],$rings_pairs)){
					$rings_pairs[$val['pair_id']]['f'] = $val;
					$rings_pairs[$val['pair_id']]['f']['name_ua'] = str_ireplace($collection_name." ",'', $val['name_ua']);
          $rings_pairs[$val['pair_id']]['f']['name_ru'] = str_ireplace($collection_name." ",'', $val['name_ru']);
          $rings_pairs[$val['pair_id']]['f']['name_en'] = str_ireplace($collection_name." ",'', $val['name_en']);
					$rings_pairs[$val['pair_id']]['collection']['name'] = $collection_name;
					$rings_pairs[$val['pair_id']]['collection']['id'] = $val['collection_id'];
					$rings_pairs[$val['pair_id']]['collection']['main_ring_id'] = $val['pair_id'];
				}else{
					$rings_pairs[$val['id']]['f'] = $val;
					$rings_pairs[$val['id']]['f']['name_ua'] = str_ireplace($collection_name." ",'', $val['name_ua']);
          $rings_pairs[$val['id']]['f']['name_ru'] = str_ireplace($collection_name." ",'', $val['name_ru']);
          $rings_pairs[$val['id']]['f']['name_en'] = str_ireplace($collection_name." ",'', $val['name_en']);
					$rings_pairs[$val['id']]['collection']['name'] = $collection_name;
					$rings_pairs[$val['id']]['collection']['id'] = $val['collection_id'];
					$rings_pairs[$val['id']]['collection']['main_ring_id'] = $val['id'];
				}
			}else{
				if(key_exists($val['pair_id'],$rings_pairs)){
					$rings_pairs[$val['pair_id']]['m'] = $val;
					$rings_pairs[$val['pair_id']]['m']['name_ua'] = str_ireplace($collection_name." ",'', $val['name_ua']);
          $rings_pairs[$val['pair_id']]['m']['name_ru'] = str_ireplace($collection_name." ",'', $val['name_ru']);
          $rings_pairs[$val['pair_id']]['m']['name_en'] = str_ireplace($collection_name." ",'', $val['name_en']);
					$rings_pairs[$val['pair_id']]['collection']['name'] = $collection_name;
					$rings_pairs[$val['pair_id']]['collection']['id'] = $val['collection_id'];
					$rings_pairs[$val['pair_id']]['collection']['main_ring_id'] = $val['pair_id'];
				}else{
					$rings_pairs[$val['id']]['m'] = $val;
					$rings_pairs[$val['id']]['m']['name_ua'] = str_ireplace($collection_name." ",'', $val['name_ua']);
          $rings_pairs[$val['id']]['m']['name_ru'] = str_ireplace($collection_name." ",'', $val['name_ru']);
          $rings_pairs[$val['id']]['m']['name_en'] = str_ireplace($collection_name." ",'', $val['name_en']);
					$rings_pairs[$val['id']]['collection']['name'] = $collection_name;
					$rings_pairs[$val['id']]['collection']['id'] = $val['collection_id'];
					$rings_pairs[$val['id']]['collection']['main_ring_id'] = $val['id'];
				}
			}
			/*$query1 = "Select id,collection_id from rings where articul='".$val['articul']."'";
			$command=$connection->createCommand($query1);
			
			$res = $command -> queryRow();
			$rings_pairs[$res['id']][$val['gender']] = $val;
			$query2 = "Select name_$lang as name,id from collection where id='".$res['collection']."'";
			$command=$connection->createCommand($query2);			
			$res1 = $command -> queryRow();
			$rings_pairs[$res['id']]['collection']['name'] = $res1['name'];
			$rings_pairs[$res['id']]['collection']['id'] = $res1['id'];
			$rings_pairs[$res['id']]['collection']['main_ring_id'] = $res['id'];*/
		}
		//print_r($rings_pairs);
		$new_coll = array();
		foreach($rings_pairs as $key => $val){
			$new_coll[] = $val;
		}
		return $new_coll;
	}
	
	  
	public function getidbyname($lang){
	  $s = Yii::app()->db->createCommand("SELECT name_$lang as name FROM rings")->queryAll();
		return $s;
	}
	
	public function getrealidbyname($name, $lang){
	  $s = Yii::app()->db->createCommand()
	  ->selectDistinct('id, collection_id')
	  ->from('rings')
	  ->where("name_$lang=:name", array(":name"=>$name))
	  ->queryAll();
	  return $s;
	}
	
	public function getfullinfo($ring_id,$lang){
		//$sql = "select * from rings where id=$ring_id and gender='m' or "
		//$sql = "select * from rings_old where weeding_id=$ring_id and gender='M'";
		$sql = "select * from rings where id=$ring_id";
		//$collection_name = Collection::model()->findByAttributes(array('remote_id'=>$_GET['collection_id']));
		$all_info =  $this -> findAllBySql($sql);
		if($all_info[0]['gender'] == 'f'){
			$list['W'] = $this -> findAllBySql($sql);
			$sql = "Select * from rings where pair_id='$ring_id'";
			$list['M'] = $this -> findAllBySql($sql);
		}else{
			$list['M'] = $this -> findAllBySql($sql);
			$sql = "Select * from rings where pair_id='$ring_id'";
			$list['W'] = $this -> findAllBySql($sql);
		}
    
    //echo '1'; die;

		if(isset($list['M'][0]['collection_id'])){
		 //echo '123';
			$sql = "Select name_$lang as name, id,remote_id from collection where remote_id='".$list['M'][0]['collection_id']."'";
		}else{
			$sql = "Select name_$lang as name, id,remote_id from collection where remote_id='".$list['W'][0]['collection_id']."'";
		}

		$list['collection'] =  Yii::app()->db->createCommand($sql)->queryRow();
		if($lang == 'ru'){
		    $list['collection']['M']['name'] = str_replace($list['collection']['name']." ",'',$list['M'][0]['name_ru']);
        $list['collection']['W']['name'] = str_replace($list['collection']['name']." ",'',$list['W'][0]['name_ru']);
		}else if($lang == 'en'){
		    $list['collection']['M']['name'] = str_replace($list['collection']['name']." ",'',$list['M'][0]['name_en']);
        $list['collection']['W']['name'] = str_replace($list['collection']['name']." ",'',$list['W'][0]['name_en']);
		}else{
		    $list['collection']['M']['name'] = str_replace($list['collection']['name']." ",'',$list['M'][0]['name_ua']);
        $list['collection']['W']['name'] = str_replace($list['collection']['name']." ",'',$list['W'][0]['name_ua']);
		}

		$list['collection']['ring_id'] = $ring_id;
    //get info for constructor
   if(isset($list['W'][0]['id']) && $list['W'][0]['id'] != ''){
     $w_ring = $list['W'][0]['id'];
     $m_ring = 0;
   }else{
     $w_ring = 0;
     $m_ring = $list['M'][0]['id'];
   }
    $list['can_metall'] = Ring::model()->getMetals($w_ring,$m_ring,$lang);
    $list['can_stones'] = Ring::model()->getStones($w_ring,$m_ring,$lang);
    $list['can_probes'] = Ring::model()->getProbes($w_ring,$m_ring,$lang,'');
    if((isset($list['W'][0]['enamel_id']) != '' && isset($list['W'][0]['enamel_id']) != 0) || (isset($list['M'][0]['enamel_id']) != '' && isset($list['M'][0]['enamel_id']) != 0)){
      $list['can_enamels'] = Enamel::model()->findAll();
      $list['can_enamels_check'] = 1;
    }else{
      $list['can_enamels']= array();
      $list['can_enamels_check'] = 0;
    }
    $list['can_surface'] = Surface::model()->findAll();
    // /print_r($list['can_stones']);
    return $list;
	}

  public function getMetals($ring_id_w = 0, $ring_id_m = 0, $lang = 'ru',$probe_name = ''){
    $ring_w = Ring::model()->findByPk($ring_id_w);
    $ring_m = Ring::model()->findByPk($ring_id_m);
    $can_metal_ids = Array();
    if($ring_w){foreach($ring_w->can_metal as $val){
      $can_metal_ids[] = "'".$val['metal_id']."'";
    }}
    if($ring_m){foreach($ring_m->can_metal as $val){
      $can_metal_ids[] = "'".$val['metal_id']."'";
    }}
    $a_query = join(',',$can_metal_ids);
    if($a_query == ''){$a_query = '0';}
    $sql = "Select DISTINCT(CONCAT(name_short,name_$lang)) as names_m, name_$lang as name from metal where id IN ($a_query)";
    $command=Yii::app()->db->createCommand($sql); 
    return $command -> queryAll();     
  }
  
  public function getMobile($id, $lang){
    $ring_w = Yii::app()->db->createCommand()
    ->select("id, collection_id, name_$lang as name, articul, metal_id, surface_id, enamel_id, size, pair_id, gender, weight, price" )
    ->from('rings')
    ->where('id=:id', array(':id'=>$id))
    ->queryAll();
    
    $surface = Yii::app()->db->createCommand()
    ->select("name_$lang")
    ->from('surface_type')
    ->where('id=:id', array(':id'=>$ring_w[0]['surface_id']))
    ->queryAll();
    $ring_w[0]['surface_type'] = $surface[0]["name_$lang"];
     
    $col_name = Yii::app()->db->createCommand()
    ->select("name_$lang")
    ->from('collection')
    ->where('remote_id=:id', array(':id'=>$ring_w[0]['collection_id']))
    ->queryAll();
    $ring_w[0]['collection_name'] = $col_name[0]["name_$lang"];
    
    
    $metal = Yii::app()->db->createCommand()
    ->select("probe, name_$lang")
    ->from('metal')
    ->where('id=:id', array(':id'=>$ring_w[0]['metal_id']))
    ->queryAll();
    $metal_name = $metal[0]["name_$lang"];
    $probe = $metal[0]['probe'];
    
     
    $ring_w[0]['metal'] = $metal_name;
    $ring_w[0]['probe'] = $probe;
    
    return $ring_w;
  }
  
  public function getProbes($ring_id_w = 0, $ring_id_m = 0,$lang = 'ru', $metal_name = ''){
    $ring_w = Ring::model()->findByPk($ring_id_w);
    $ring_m = Ring::model()->findByPk($ring_id_m);
    $can_metal_ids = Array();
    $add_query = '';
    if($ring_w){
      foreach($ring_w->can_metal as $val){
       $can_metal_ids[] = "'".$val['metal_id']."'";
      }
    }
    if($ring_m){
      foreach($ring_m->can_metal as $val){
        $can_metal_ids[] = "'".$val['metal_id']."'";
      }
    }
    $a_query = join(',',$can_metal_ids);
    if($metal_name != ''){
      $add_query = " and CONCAT(name_short,name_$lang) = '$metal_name'";
    }
    $sql = "Select DISTINCT(probe) as probes from metal where id IN ($a_query) $add_query order by probes";
    $command=Yii::app()->db->createCommand($sql); 
    return $command -> queryAll();     
  }
  
  public function getStones($ring_id_w = 0, $ring_id_m = 0, $lang){
    $ring_w = Ring::model()->findByPk($ring_id_w);
    $ring_m = Ring::model()->findByPk($ring_id_m);
    /*$can_stones_types = Array();
    if($ring_w){
      foreach($ring_w->can_stones as $val){
       $can_stones_types[] = "'".$val['stone_id']."'";
      }
    }
    if($ring_m){
      foreach($ring_m->can_stones as $val){
        $can_stones_types[] = "'".$val['stone_id']."'";
      }
    }
    #print_r($can_stones_types);
    $a_query = join(',',$can_stones_types);
    if($a_query != ''){
    $sql = "Select id, name_$lang as stone_type from stone_type where id IN ($a_query)";
   //echo $sql;
    $command=Yii::app()->db->createCommand($sql); 
    return $command -> queryAll();
    }else{
      return '';
    }     */
    $can_w = $ring_w['only_st_stones'];
    $can_m = $ring_m['only_st_stones'];
    if($can_w == 0){
      if(count(isset($ring_w->stones)) == 0){
        $can_w = 1;
      }
    }
    if($can_m == 0){
     if(count(isset($ring_m->stones)) == 0){
        $can_m = 1;
      }
    }
    return array('w' => $can_w, 'm' => $can_m);
  }
  
  
	public function sitesearch($search, $filter, $cost,$lang){
		$connection=Yii::app()->db; 
		$cost = " order by price $cost";
		$sql = "Select remote_id from collection where name_$lang LIKE '%".$search."%'";
		$command=$connection->createCommand($sql);			
		$res_collection = $command -> queryAll();
		$add_sql = '';
		//print_r($res_collection);
		if(count($res_collection) > 0){
			$add_sql = " OR collection_id IN (";
			foreach($res_collection as $collect){
				$add_sql .= "'".$collect['id']."',";
			} 
			$add_sql = substr($add_sql,0,-1);
			$add_sql .= ')';
		}
		//print_r($add_sql);die;
		if($filter == 'all'){
			$sql = "Select * from rings where parent_id=0 and name_$lang LIKE '%".$search."%' or articul LIKE '%".$search."%' $add_sql $cost";
		}else{
			if($filter == 'M'){$filter = 'm';}else{$filter='f';}
			$sql = "Select * from rings where parent_id=0 and gender='$filter' and (name_$lang LIKE '%".$search."%' $add_sql) $cost";
		}
		//echo $sql;die;
		$list = $this -> findAllBySql($sql);
		$rings_pairs = Array();
    //print_r($list); die;
    if(is_array($list) && count($list) != 0){
		foreach($list as $val){
			if(is_file('./old_images/'.$val['articul'].'.png')){
			$collection = Collection::model()->findByAttributes(array('remote_id'=>$val['collection_id']));
       // print_r($collection); die;
       if($collection){
        $collection_name = $collection->getLangProp('name');
			if($val['gender'] == 'f'){
				if(key_exists($val['pair_id'],$rings_pairs)){
					$rings_pairs[$val['pair_id']]['f'] = $val;
					$rings_pairs[$val['pair_id']]['f']['name_ua'] = str_ireplace($collection_name." ",'', $val['name_ua']);
          $rings_pairs[$val['pair_id']]['f']['name_ru'] = str_ireplace($collection_name." ",'', $val['name_ru']);
          $rings_pairs[$val['pair_id']]['f']['name_en'] = str_ireplace($collection_name." ",'', $val['name_en']);
					$rings_pairs[$val['pair_id']]['collection']['name'] = $collection_name;
					$rings_pairs[$val['pair_id']]['collection']['id'] = $val['collection_id'];
					$rings_pairs[$val['pair_id']]['collection']['main_ring_id'] = $val['pair_id'];
				}else{
					$rings_pairs[$val['id']]['f'] = $val;
					$rings_pairs[$val['id']]['f']['name_ua'] = str_ireplace($collection_name." ",'', $val['name_ua']);
          $rings_pairs[$val['id']]['f']['name_ru'] = str_ireplace($collection_name." ",'', $val['name_ru']);
          $rings_pairs[$val['id']]['f']['name_en'] = str_ireplace($collection_name." ",'', $val['name_en']);
					$rings_pairs[$val['id']]['collection']['name'] = $collection_name;
					$rings_pairs[$val['id']]['collection']['id'] = $val['collection_id'];
					$rings_pairs[$val['id']]['collection']['main_ring_id'] = $val['id'];
				}
			}else{
				if(key_exists($val['pair_id'],$rings_pairs)){
					$rings_pairs[$val['pair_id']]['m'] = $val;
					$rings_pairs[$val['pair_id']]['m']['name_ua'] = str_ireplace($collection_name." ",'', $val['name_ua']);
          $rings_pairs[$val['pair_id']]['m']['name_ru'] = str_ireplace($collection_name." ",'', $val['name_ru']);
          $rings_pairs[$val['pair_id']]['m']['name_en'] = str_ireplace($collection_name." ",'', $val['name_en']);
					$rings_pairs[$val['pair_id']]['collection']['name'] = $collection_name;
					$rings_pairs[$val['pair_id']]['collection']['id'] = $val['collection_id'];
					$rings_pairs[$val['pair_id']]['collection']['main_ring_id'] = $val['pair_id'];
				}else{
					$rings_pairs[$val['id']]['m'] = $val;
					$rings_pairs[$val['id']]['m']['name_ua'] = str_ireplace($collection_name." ",'', $val['name_ua']);
          $rings_pairs[$val['id']]['m']['name_ru'] = str_ireplace($collection_name." ",'', $val['name_ru']);
          $rings_pairs[$val['id']]['m']['name_en'] = str_ireplace($collection_name." ",'', $val['name_en']);
					$rings_pairs[$val['id']]['collection']['name'] = $collection_name;
					$rings_pairs[$val['id']]['collection']['id'] = $val['collection_id'];
					$rings_pairs[$val['id']]['collection']['main_ring_id'] = $val['id'];
				}
			}
			}
		}
		}
		}
		//print_r($rings_pairs);
		$new_coll = array();
		if(count($rings_pairs) > 0){
		foreach($rings_pairs as $key => $val){
			$new_coll[] = $val;
		}}
		return $new_coll;
	}

}

?>