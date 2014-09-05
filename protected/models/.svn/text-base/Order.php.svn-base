<?php

/**
 * This is the model class for table "static_pages".
 *
 * The followings are the available columns in table 'static_pages':
 * @property integer $id
 * @property text $all_info
 */
class Order extends CActiveRecord
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
    return 'orders';
  }

  /**
   * @return array validation rules for model attributes.
   */
  public function rules()
  {
    return array
    (
      array('id, name, email, city, all_info', 'required', 'message' => '{attribute} не должен быть пустым'),
      array('all_info, comment, city, phone', 'safe'),
//      array('value_ru, value_ua', 'filter', 'filter' => array($this->arfilters, 'purifyRich')),
      array('id, name, email', 'safe', 'on'=>'search')
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
      'name' => 'Имя',
      'phone' => 'Телефон',
      'email' => 'Email',
      'city' => 'Город',
      'comment' => 'Комментарий',
      'all_info' => 'Информация о заказе'
    );
  }

  /**
   * Retrieves a list of models based on the current search/filter conditions.
   * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
   */
   public function search()
  {
    $criteria = new CDbCriteria;

    $criteria->compare('name', $this->name, true);
    $criteria->compare('email', $this->email, true);
    $criteria->compare('phone', $this->phone, true);

    return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => array('defaultOrder' => 'id desc')));
  }
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