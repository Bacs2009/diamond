<?php

/**
 * This is the model class for table "city_item".
 *
 * The followings are the available columns in table 'city_item':
 * @property integer $id
 * @property string $name_ru
 * @property string $name_ua
 * @property string $lat
 * @property string $lng
 */
class CityItem extends CActiveRecord
{

/*
	public $name_ru;
    public $name_ua;
*/

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return CityItem the static model class
	 */
	 
	public function getDbConnection()
	{
		return Yii::app()->db;
	}
	
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'city_item';
	}

/*
	public function init()
	{
		$this->name_ru = '';
		$this->name_ua = '';
	}
*/

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array
		(
			array('name_ru, name_ua, name_en, lat, lng', 'required', 'message' => '{attribute} не может быть пустым'),
		 	array('name_ru, name_ua, name_en', 'filter', 'filter' => array($this->arfilters, 'purifyStrong')),
			array('name_ru, name_ua, name_en', 'length', 'max' => 20),
			array('lat, lng', 'length', 'max' => 12),
			array('name_ru, name_ua, name_en', 'safe', 'on' => 'search'),
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
			'name_ru' => 'Город (рус)',
			'name_ua' => 'Город (укр)',
			'name_en' => 'Город (англ)',
			'lat' => 'Широта (lat)',
			'lng' => 'Долгота (lng)'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('name_ru', $this->name_ru, true);
		$criteria->compare('name_ua', $this->name_ua, true);
    $criteria->compare('name_en', $this->name_en, true);

		return new CActiveDataProvider($this, array('criteria' => $criteria));
	}
	
	public function behaviors()
	{
	 	return array
	 	(
	 		'arfilters' => array('class' => 'application.components.Behavior.ARFiltersBehavior'),
			'ViewLog' => array('class' => 'application.components.Behavior.ViewLogBehavior')
		);
	}

	public function getLangProp($property)
	{
		return $this->{$property . '_' . Yii::app()->params->language};
	}

}

?>