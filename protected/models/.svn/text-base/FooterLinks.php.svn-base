<?php

/**
 * This is the model class for table "footer_links".
 *
 * The followings are the available columns in table 'footer_links':
 * @property integer $id
 * @property string $name_ru
 * @property string $name_ua
 * @property string $href_ru
 * @property string $href_ua
 * @property integer $orders
 * @property integer $active
 */
class FooterLinks extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FooterLinks the static model class
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
		return 'footer_links';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array
		(
			array('name_ru, name_ua, name_en, href_ru, href_ua, href_en, active', 'required', 'message' => '{attribute} не должно быть пустым'),
			array('orders, active', 'numerical', 'integerOnly'=>true),
			array('name_ru, name_ua, name_en', 'length', 'max'=>75),
			array('href_ru, href_ua, href_en', 'length', 'max'=>150),
			array('name_ru, name_ua, name_en, href_ru, href_ua, href_en', 'safe', 'on'=>'search')
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
			'href_ru' => 'Ссылка (рус)',
			'href_ua' => 'Ссылка (укр)',
			'href_en' => 'Ссылка (англ)',
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

		$criteria->compare('name_ru', $this->name_ru, true);
		$criteria->compare('name_ua', $this->name_ua, true);
    $criteria->compare('name_en', $this->name_en, true);
		$criteria->compare('href_ru', $this->href_ru, true);
		$criteria->compare('href_ua', $this->href_ua, true);
    $criteria->compare('href_en', $this->href_en, true);

		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => array('defaultOrder' => 'orders')));
	}

	public function beforeSave()
	{
		$this->updateTime = new CDbExpression('NOW()');

		if($this->isNewRecord)
		{
			$orders = Yii::app()->db->createCommand('SELECT MAX(orders) FROM ' . $this->tableName())->queryScalar();
			$this->orders = $orders + 1;
		}
	
		return parent::beforeSave();
	}

	public function beforeDelete()
	{
		$orders = Yii::app()->db->createCommand('SELECT orders FROM ' . $this->tableName() . ' WHERE id=' . $this->primaryKey)->queryScalar();

		Yii::app()->db->createCommand('UPDATE ' . $this->tableName() . ' SET orders=orders-1 WHERE orders>' . $orders)->execute();

    return parent::beforeDelete();
	}

	public function afterDelete()
	{
		$result = parent::afterDelete();

		$id = Yii::app()->db->createCommand('SELECT id FROM ' . $this->tableName() . ' ORDER BY updateTime DESC')->queryScalar();

		Yii::app()->db->createCommand('UPDATE ' . $this->tableName() . ' SET updateTime=NOW() WHERE id=' . $id)->execute();

		return $result;
	}

	public function getItems($language)
	{
		$dependency = new CDbCacheDependency('SELECT MAX(updateTime), \'' . $language . '\' lng FROM ' . $this->tableName());

		$items = $this->cache(3600, $dependency)->findAllBySql('SELECT name_' . $language . ', href_' . $language . ' FROM ' . $this->tableName() . ' WHERE active=1 ORDER BY orders');

		$result = array();

		foreach($items as $key => $value)
		{
			$result[] = array('text' => $value->getLangProp('name'), 'href' => $value->getLangProp('href'));
		}

		return $result;
	}

	public function getLangProp($property)
	{
		return $this->{$property . '_' . Yii::app()->params->language};
	}

}

?>