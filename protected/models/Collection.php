<?php

/**
 * This is the model class for table "collection".
 *
 * The followings are the available columns in table 'collection':
 * @property integer $id
 * @property integer $remote_id
 * @property string $name_ru
 * @property string $name_ua
 * @property integer $active
 * @property integer $orders
 * @property string $text_ru
 * @property string $text_ua
 * @property string $menu_color
 * @property string $menu_color_add
 */
class Collection extends CActiveRecord
{
	public $menu_color_add;
	public $menu_color;
	public $bg1_class;
	public $bg2_class;
	public $bg3_class;
	public $bg4_class;
	public $image;
  public $formula;
    public $imageForMainPage;
	public $bg_all_class;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Collection the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'collection';
	}

	public function init() {
        $this->name_ru = '';
        $this->text_ru = '';
		    $this->name_ua = '';
        $this->text_ua = '';
        $this->name_en = '';
        $this->text_en = '';
        $this->active = false;
        $this->menu_color = false;
        $this->menu_color_add = false;
		$this->bg1_class = '';
		$this->bg2_class = '';
		$this->bg3_class = '';
		$this->bg4_class = '';
		$this->bg_all_class = '';
    $this->formula = '';
    }
  
  public function getIdByRemoteId($remote_id){
    
    $sql = "Select id from " . $this->tableName() . " where remote_id='$remote_id'";
    echo $sql;
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    print_r($result);
   // return $result['id'];
  }
    public function getIdByRemoteId_inner($remote_id){
      
    $sql = "Select * from " . $this->tableName() . " where remote_id='$remote_id'";
   // echo $sql;
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    
    //print_r($result);
   return $result;
  }
	public function getAll()
	{
	  
		$SQL = 'SELECT * FROM ' . $this->tableName() . ' WHERE active="1"';
		$list = $this->cache(300)->findAllBySql($SQL, array());
		return $list;
	}
	
	 public function behaviors() {
        return array(
            
            'imageProcessing' => array(
                'class' => 'application.components.Behavior.ARImageProcessingBehavior',
                'images' => array(
                    'big' => array(
                        'attribute' => 'image',
                        'width' => 478,
                        'height' => 230,
                        'mode' => 'outer',
                        'cropH' => 'center',
                        'cropV' => 'top',
                        'img_type' => 'png'
                    ),
                    'forMain' => array(
                        'attribute' => 'imageForMainPage',
                        'width' => 151,
                        'height' => 80,
                        'mode' => 'outer',
                        'cropH' => 'center',
                        'cropV' => 'top',
                        'img_type' => 'png'
                    )
                ),
             ),
			'ordering' => array('class' => 'application.components.Behavior.OrderingBehavior')
        );
    }
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('remote_id, active, orders', 'numerical', 'integerOnly'=>true),
			array('name_ru, name_ua, name_en, menu_color, menu_color_add, bg1_class, bg2_class, bg3_class, bg4_class, bg_all_class', 'length', 'max'=>50),
			array('text_ru, text_ua, text_en, formula', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, remote_id, name_ru, name_ua, name_en, active, orders, text_ru, text_ua, text_en, menu_color,formula', 'safe', 'on'=>'search'),
		);
	}


	public function getLangProp($property)
	{
		return $this->{$property . '_' . Yii::app()->params->language};
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'remote_id' => 'ID в 1с',
			'name_ru' => 'Название (рус)',
			'name_ua' => 'Название (укр)',
			'name_en' => 'Название (англ)',
			'active' => 'Активно',
			'orders' => 'Сортировка',
			'text_ru' => 'Описание (рус)',
			'text_ua' => 'Описание (укр)',
			'text_en' => 'Описание (англ)',
			'image' => 'Картинка (478х230)',
			'imageForMainPage' => 'Картинка в попапе (151х80)',
			'menu_color' => 'Цвет меню',
			'formula' => 'Формула',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('remote_id',$this->remote_id);
		$criteria->compare('name_ru',$this->name_ru,true);
		$criteria->compare('name_ua',$this->name_ua,true);
    $criteria->compare('name_en',$this->name_en,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('orders',$this->orders);
		$criteria->compare('text_ru',$this->text_ru,true);
		$criteria->compare('text_ua',$this->text_ua,true);
    $criteria->compare('text_en',$this->text_en,true);
    $criteria->compare('formula',$this->formula,true);
		$criteria->compare('menu_color',$this->menu_color,true);
		$criteria->compare('menu_color_add',$this->menu_color_add,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function beforeSave()
		{
			if($this->isNewRecord)
			{
				$Max = Yii::app()->db->createCommand('SELECT MAX(orders) FROM ' . $this->tableName())->queryScalar();
				$this->orders = $Max + 1;
			}
	
			return parent::beforeSave();
		}
}