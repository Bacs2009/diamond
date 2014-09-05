<?php

/**
 * This is the model class for table "shops".
 *
 * The followings are the available columns in table 'shops':
 * @property integer $id
 * @property integer $city_id
 * @property string $address_ru
 * @property string $name_ru
 * @property string $phone_ru
 * @property string $lat
 * @property string $lng
 * @property integer $active
 * @property string $address_en
 * @property string $name_en
 * @property string $phone_en
 */
class Shops extends CActiveRecord
{
//	public $map;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Shops the static model class
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
		return 'shops';
	}
	 
	public function getCityItems()
	{
		$citiesModel = CityItem::model()->findAll(array('order' => 'name_ru'));

		// format models as $key=>$value with listData
		return CHtml::listData($citiesModel, 'id', 'name_ru');
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array
		(
			array('city_id, active', 'numerical', 'integerOnly' => true),
			array('address_ru, phone_ru, address_ua, phone_ua, address_en, phone_en', 'length', 'max' => 255),
			array('name_ru, name_ua,name_en', 'length', 'max' => 100),
			array('lat, lng', 'length', 'max' => 12),
			array('id, city_id, address_ru, name_ru, phone_ru, lat, lng, active, address_ua, name_ua, phone_ua, address_en, name_en, phone_en', 'safe', 'on' => 'search')
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array('cityItem' => array(self::BELONGS_TO, 'CityItem', 'city_id'));
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array
		(
			'id' => 'ID',
			'city_id' => 'Город',
			'address_ru' => 'Адрес (рус)',
			'name_ru' => 'Название (рус)',
			'phone_ru' => 'Телефон (рус)',
			'lat' => 'Lat',
			'lng' => 'Lng',
			'active' => 'Активно',
			'address_ua' => 'Адрес (укр)',
			'name_ua' => 'Название (укр)',
			'phone_ua' => 'Телефон (укр)',
			'address_en' => 'Адрес (англ)',
      'name_en' => 'Название (англ)',
      'phone_en' => 'Телефон (англ)'
		);
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
					'preview' => array
					(
						'attribute' => 'previewImage',
						'width' => 125,
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

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria = new CDbCriteria;

//		$criteria->compare('id', $this->id);
		$criteria->compare('city_id', $this->city_id);
//		$criteria->compare('address_ru', $this->address_ru, true);
		$criteria->compare('name_ru', $this->name_ru, true);
/*
		$criteria->compare('phone_ru', $this->phone_ru, true);
		$criteria->compare('lat', $this->lat, true);
		$criteria->compare('lng', $this->lng, true);
		$criteria->compare('active', $this->active);
		$criteria->compare('address_ua', $this->address_ua, true);
		$criteria->compare('name_ua', $this->name_ua, true);
		$criteria->compare('phone_ua', $this->phone_ua, true);
*/

		return new CActiveDataProvider($this, array('criteria' => $criteria));
	}

	public function getLangProp($property)
	{
		return $this->{$property . '_' . Yii::app()->params->language};
	}

}

?>