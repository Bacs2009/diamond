<?php

/**
 * This is the model class for table "static_pages".
 *
 * The followings are the available columns in table 'static_pages':
 * @property string $key
 * @property string $value_ru
 * @property string $value_ua
 */
class StaticPages extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return StaticPages the static model class
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
		return 'static_pages';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array
		(
			array('key, value_ru, value_ua, value_en', 'required', 'message' => '{attribute} не должен быть пустым'),
			array('key', 'length', 'max' => 50),
			array('value_ru, value_ua, value_en', 'safe'),
//			array('value_ru, value_ua', 'filter', 'filter' => array($this->arfilters, 'purifyRich')),
			array('value_ru, value_ua,value_en', 'safe'),
			array('key, value_ru, value_ua,value_en', 'safe', 'on'=>'search')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array
		(
			'key' => 'Ключ',
			'value_ru' => 'Текст (рус)',
			'value_ua' => 'Текст (укр)',
			'value_en' => 'Текст (англ)'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
/*
	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('key', $this->key, true);
		$criteria->compare('value_ru', $this->value_ru, true);
		$criteria->compare('value_ua', $this->value_ua, true);

		return new CActiveDataProvider($this, array('criteria' => $criteria));
	}
*/

	function behaviors()
	{
		return array('arfilters' => array('class' => 'application.components.Behavior.ARFiltersBehavior'));
	}

}

?>