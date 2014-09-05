<?php

/**
 * This is the model class for table "actions".
 *
 * The followings are the available columns in table 'actions':
 * @property string $id
 * @property string $title_ru
 * @property string $title_ua
 * @property string $description_ru
 * @property string $description_ua
 * @property string $startDate
 * @property string $endDate
 * @property string $onmain
 * @property string $updatetime
 * @property integer $active
 * @property string $link
 */
class Actions extends CActiveRecord
{
	public $bigImage;
	public $previewImage;
	public $startDate, $endDate;

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
		return 'actions';
	}

	public function init()
	{
		$this->startDate = Yii::app()->dateFormatter->format('yyyy-MM-dd kk:mm:ss', time());
		$this->endDate = Yii::app()->dateFormatter->format('yyyy-MM-dd kk:mm:ss', time());
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array
		(
			array('title_ru, title_ua, title_en, description_ru, description_ua, description_en, startDate, endDate, onmain, active', 'required', 'message' => '{attribute} не может быть пустым'),
			array('startDate, endDate', 'type', 'type' => 'datetime', 'datetimeFormat' => 'dd.MM.yyyy hh:mm'),
			array('startDate, endDate', 'filter', 'filter' => array($this->arfilters, 'dateTimeFilter')),
			//array('title_ru, title_ua, description_ru, description_ua', 'filter', 'filter' => array($this->arfilters, 'purifyRich')),
			array('onmain, active', 'numerical', 'integerOnly' => true),
			array('title_ru, title_ua, title_en', 'length', 'max' => 100),
			array('link', 'length', 'max' => 500),
			array('bigImage, previewImage', 'file', 'types' => 'png', 'allowEmpty' => true, 'wrongType' => 'Файл <strong>{file}</strong> должен быть в формате <strong>{extensions}</strong>'),
			array('title_ru, title_ua, title_en, description_ru, description_ua, description_en', 'safe', 'on' => 'search')
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
			'title_ru' => 'Заголовок (рус)',
			'title_ua' => 'Заголовок (укр)',
			'title_en' => 'Заголовок (англ)',
			'description_ru' => 'Описание (рус)',
			'description_ua' => 'Описание (укр)',
			'description_en' => 'Описание (англ)',
			'startDate' => 'Дата начала',
			'endDate' => 'Дата завершения',
			'onMain' => 'Показывать на главной',
			'bigImage' => 'Большая картинка (478х230, *.png)',
			'previewImage' => 'Превью (97х80, *.png)',
			'active' => 'Активна',
			'link' => 'Ссылка'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('title_ru', $this->title_ru, true);
		$criteria->compare('title_ua', $this->title_ua, true);
    $criteria->compare('title_en', $this->title_en, true);
		$criteria->compare('description_ru', $this->description_ru, true);
		$criteria->compare('description_ua', $this->description_ua, true);
    $criteria->compare('description_en', $this->description_en, true);

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

	public function beforeSave()
	{
		$this->updatetime = new CDbExpression('NOW()');

		return parent::beforeSave();
	}

	public function getUrl()
	{
		return Yii::app()->urlManager->createAbsoluteLanguageUrl('actions/view', array('id' => $this->primaryKey));
	}

	public function getList($language, $offset = 0, $limit = 8)
	{
//		$dependency = new CDbCacheDependency('SELECT MAX(updateTime), \'' . $language . '\' lng FROM ' . $this->tableName());

		$dependency = new CDbCacheDependency('SELECT MAX(updatetime) FROM ' . $this->tableName());

		$date = Yii::app()->dateFormatter->format('yyyy-MM-dd kk:mm:ss', time());

		$sql = 'SELECT id, title_' . $language . ', description_' . $language . ', link FROM ' . $this->tableName() . ' WHERE active=1 AND startDate<\'' . $date . '\' AND endDate>\'' . $date . '\' ORDER BY startDate DESC LIMIT :offset, :limit';
		$list = $this->cache(600, $dependency)->findAllBySql($sql, array(':offset' => $offset, ':limit' => $limit + 1));

		return array('list' => array_slice($list, 0, $limit), 'count' => sizeof($list));
	}

	public function getForMain($language)
	{
//		$dependency = new CDbCacheDependency('SELECT MAX(updateTime), \'' . $language . '\' lng FROM ' . $this->tableName());

		$dependency = new CDbCacheDependency('SELECT MAX(updatetime) FROM ' . $this->tableName() . ' WHERE onMain=1');

		$date = Yii::app()->dateFormatter->format('yyyy-MM-dd kk:mm:ss', time());

		$sql = 'SELECT id, title_' . $language . ', link FROM ' . $this->tableName() . ' WHERE active=1 AND onMain=1 AND startDate<\'' . $date . '\' AND endDate>\'' . $date . '\' ORDER BY startDate DESC LIMIT 3';
		$list = $this->cache(600, $dependency)->findAllBySql($sql);

		return $list;
	}

	public function getLangProp($property)
	{
		return $this->{$property . '_' . Yii::app()->params->language};
	}

}

?>