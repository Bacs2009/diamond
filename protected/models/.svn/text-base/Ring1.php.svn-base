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
		return 'rings_old';
	}

	public function init()
	{
		
	}

	public function relations()
	{
		 return array(
            'order_stones' => array(self::HAS_MANY, 'OrderStones', 'rings_id'),
            'jewellery_metals' => array(self::HAS_MANY, 'JewelleryMetals','rings_id')
        );
	}
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array
		(
			array('article,collection_id,metal_id,metal_color', 'required', 'message' => '{attribute} не может быть пустым'),
			array('name_ru, name_ua', 'filter', 'filter' => array($this->arfilters, 'purifyRich')),
			array('onMain, active', 'numerical', 'integerOnly' => true),
			array('title_ru, title_ua', 'length', 'max' => 100),
			array('bigImage, previewImage', 'file', 'types' => 'png', 'allowEmpty' => true, 'wrongType' => 'Файл <strong>{file}</strong> должен быть в формате <strong>{extensions}</strong>'),
			array('name_ua,name_ru', 'safe', 'on' => 'search')
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
		if(Yii::app()->language == 'uk_UA'){$lang = 'ua';}else{ $lang='ru'; }
		return $this->{$property . '_' . $lang};
	}
	
	public function getRingsCollection($collection_id){
		$sql = "Select * from rings_old where collection_id=$collection_id and weeding_id != '' and weeding_id is not NULL order by id";
		//echo $sql; die;
		$list = $this -> findAllBySql($sql);
		//print_r($list[0]); die;
		return $list;
	}
	
	public function getRings($collection_id){
		$sql = "Select c.artw, r.* from weddingrings as c,rings_old as r where c.collection=$collection_id and c.artw=r.article order by r.id";
		//echo $sql;
		$list = $this -> findAllBySql($sql);
		//print_r($list[0]); die;
		return $list;
	}
	
	public function getRingsByIds($ids,$lang){
		$new_ids = array();
		foreach($ids as $val){
			$new_ids[] = "'".$val."'";
		}
		$connection=Yii::app()->db;   // assuming you have configured a "db" connection
		$to_select = implode(',',$new_ids);
		$sql = "Select * from rings_old as r where r.id in ($to_select) order by r.id";
		$list = $this -> findAllBySql($sql);
		foreach($list as $val){
			$query1 = "Select id,collection, artw, artm from weddingrings where artw='".$val['article']."' OR artm='".$val['article']."'";
			$command=$connection->createCommand($query1);
			
			$res = $command -> queryRow();
			$rings_pairs[$res['id']][$val['gender']] = $val;
			$query2 = "Select name_$lang as name,id from collection where id='".$res['collection']."'";
			$command=$connection->createCommand($query2);			
			$res1 = $command -> queryRow();
			$rings_pairs[$res['id']]['collection']['name'] = $res1['name'];
			$rings_pairs[$res['id']]['collection']['id'] = $res1['id'];
			$rings_pairs[$res['id']]['collection']['main_ring_id'] = $res['id'];
		}
		$new_coll = array();
		foreach($rings_pairs as $key => $val){
			$new_coll[] = $val;
		}
		return $new_coll;
	}
	
	public function getfullinfo($ring_id,$lang){
		$sql = "select * from rings_old where weeding_id=$ring_id and gender='M'";
		$list['M'] = $this -> findAllBySql($sql);
		$sql = "select * from rings_old where weeding_id=$ring_id and gender='W'";
		$list['W'] = $this -> findAllBySql($sql);
		if($list['M'][0]['collection_id']){
			$sql = "Select name_$lang as name, id from collection where id='".$list['M'][0]['collection_id']."'";
		}else{
			$sql = "Select name_$lang as name, id from collection where id='".$list['W'][0]['collection_id']."'";
		}
		$list['collection'] =  Yii::app()->db->createCommand($sql)->queryRow();
		$list['collection']['ring_id'] = $ring_id;
        return $list;
	}
	public function sitesearch($search, $filter, $cost,$lang){
		$connection=Yii::app()->db; 
		$cost = " order by price $cost";
		$sql = "Select id from collection where name_$lang LIKE '%".$search."%'";
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
			$sql = "Select * from rings_old where name_$lang LIKE '%".$search."%' $add_sql $cost";
		}else{
			$sql = "Select * from rings_old where gender='$filter' and (name_$lang LIKE '%".$search."%' $add_sql) $cost";
		}
		
		$list = $this -> findAllBySql($sql);
		
		foreach($list as $val){
			$query1 = "Select id,collection, artw, artm from weddingrings where artw='".$val['article']."' OR artm='".$val['article']."'";
			//echo $query1;
			$command=$connection->createCommand($query1);
			$res = $command -> queryRow();
			$rings_pairs[$res['id']][$val['gender']] = $val;
			$query2 = "Select name_$lang as name,id from collection where id='".$res['collection']."'";
			//echo $query2;
			$command=$connection->createCommand($query2);			
			$res1 = $command -> queryRow();
			$rings_pairs[$res['id']]['collection']['name'] = $res1['name'];
			$rings_pairs[$res['id']]['collection']['id'] = $res1['id'];
			$rings_pairs[$res['id']]['collection']['main_ring_id'] = $res['id'];
		}
		$new_coll = array();
		if(count($rings_pairs) > 0){
		foreach($rings_pairs as $key => $val){
			$new_coll[] = $val;
		}}
		return $new_coll;
	}

}

?>