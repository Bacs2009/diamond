<?php
class Stones extends CActiveRecord
{

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
    return 'stones';
  }

  public function init()
  {
    
  }
  public function relations()
  {
    return array('rings' => array(self::HAS_MANY, 'StoneToRing', 'stone_id'));
  }
  
  /**
   * @return array validation rules for model attributes.
   */
  public function rules()
  {
    return array
    (
      /*array('article,collection_id,metal_id,metal_color', 'required', 'message' => '{attribute} не может быть пустым'),
      array('name_ru, name_ua', 'filter', 'filter' => array($this->arfilters, 'purifyRich')),
      array('onMain, active', 'numerical', 'integerOnly' => true),
      array('title_ru, title_ua', 'length', 'max' => 100),
      array('bigImage, previewImage', 'file', 'types' => 'png', 'allowEmpty' => true, 'wrongType' => 'Файл <strong>{file}</strong> должен быть в формате <strong>{extensions}</strong>'),
      array('name_ua,name_ru', 'safe', 'on' => 'search')*/
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
      'name_ua' => 'name_ua',
      'rings_id' => 'rings_id'
    );
  }

  /**
   * Retrieves a list of models based on the current search/filter conditions.
   * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
   */
  public function search()
  {
    $criteria = new CDbCriteria;

    //$criteria->compare('name_ru', $this->title_ru, true);
    //$criteria->compare('naem_ua', $this->title_ua, true);

    return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => array('defaultOrder' => 'id DESC')));
  }

  public function getLangProp($property)
  {
    return $this->{$property . '_' . Yii::app()->params->language};
  }


/*  public function beforeSave()
  {
    $this->updateTime = new CDbExpression('NOW()');

    return parent::beforeSave();
  }*/


}

?>