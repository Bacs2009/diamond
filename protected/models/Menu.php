<?php

/**
 * This is the model class for table "menu".
 *
 * The followings are the available columns in table 'menu':
 * @property integer $id
 * @property string $name_ru
 * @property string $name_ua
 * @property string $href_ru
 * @property string $href_ua
 * @property string $title_ua
 * @property string $title_ru
 * @property integer $system
 * @property integer $orders
 * @property integer $active
 * @property varchar $updateTime
 *
 */

class Menu extends CActiveRecord
{

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Menu the static model class
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
		return 'menu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array
		(
			array('name_ru, name_ua,name_en,  active, title_ua,title_ru,title_en, description_ua, description_ru, description_en', 'required', 'message' => '{attribute} не должно быть пустым'),
			array('system, orders, active', 'numerical', 'integerOnly' => true),
			array('name_ru, name_ua, name_en', 'length', 'max' => 75),
			array('description_ru, description_ua, description_en', 'safe'),
			array('href_ru, href_ua, href_en, title_ua,title_ru, title_en', 'length', 'max' => 150),
			array('name_ru, name_ua, name_en', 'safe', 'on' => 'search')
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
			'name_en' => "Название (англ)",
			'href_ru' => 'Ссылка (рус)',
			'href_ua' => 'Ссылка (укр)',
			'href_en' => 'Ссылка (англ)',
			'title_ru' => "Тайтл (рус)",
			'title_ua' => "Тайтл (укр)",
			'title_en' => "Тайтл (англ)",
			'description_ua' => 'Мета описание (укр)',
			'description_ru' => 'Мета описание (рус)',
			'description_en' => 'Мета описание (англ)',
			'active' => 'Активен'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria = new CDbCriteria;

		$criteria->compare('name_ru', $this->name_ru,true);
		$criteria->compare('name_ua', $this->name_ua,true);
    $criteria->compare('name_en', $this->name_en,true);
    $criteria->compare('title_ru', $this->name_ru,true);
    $criteria->compare('title_ua', $this->name_ua,true);
    $criteria->compare('title_en', $this->name_en,true);
		$criteria->compare('href_ru', $this->href_ru,true);
		$criteria->compare('href_ua', $this->href_ua,true);
    $criteria->compare('href_en', $this->href_en,true);
		$criteria->compare('active', $this->active);

		return new CActiveDataProvider($this, array('criteria' => $criteria, 'sort' => array('defaultOrder' => 'orders')));
	}

	public function beforeSave()
	{
		$this->updatetime = new CDbExpression('NOW()');
		$this->href_ru = trim($this->href_ru, '/');
		$this->href_ua = trim($this->href_ua, '/');
    $this->href_en = trim($this->href_en, '/');

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

		$items = $this->findAllBySql('SELECT id, name_' . $language . ', href_' . $language . ' FROM ' . $this->tableName() . ' WHERE active=1 ORDER BY orders');

		$result = array();

		foreach($items as $key => $value)
		{
			$result[] = array('label' => $value->getLangProp('name'), 'url' => $value->getLangProp('href'),'id'=>$value['id']);
		}

		return $result;
	}
  
  public function get_meta($url,$lang){
    $sql = "Select title_$lang as title, description_$lang as description from menu where href_$lang = '$url'";
    $result = Yii::app()->db->createCommand($sql)->queryRow();
    return $result;
  }
  
	public function getItemByUrl($language)
	{
		$url = Yii::app()->request->requestUri;
		$langUrl = '/' . $language . '/';

		if(strpos($url, $langUrl) === 0)
		{
			$url = substr($url, strlen($langUrl));
		}
		else
		{
			$url = trim($url, '/');
		}

		$url = explode('/', $url);
		$count = sizeof($url);

		$menu = $this->getItems($language);
		$matches = array();

		foreach($menu as $key => $value)
		{
			$menuUrl = explode('/', $value['url']);

			for($i = 0; $i < $count; $i++)
			{
				if(!isset($menuUrl[$i])) break;

				if($url[$i] === $menuUrl[$i])
				{
					if(!isset($matches[$key]))
					{
						$matches[$key] = 0;
					}

					$matches[$key]++;
				}
			}
		}

		if(empty($matches)) return false;

		arsort($matches, SORT_NUMERIC);

		$matched = each($matches);

		$item = $menu[$matched['key']];
		$item['url'] = Yii::app()->urlManager->createAbsoluteLanguageUrl('site/index') . '/' . $item['url'];

		return $item;
	}
 
  
	public function getLangProp($property)
	{
		return $this->{$property . '_' . Yii::app()->params->language};
	}

}

?>