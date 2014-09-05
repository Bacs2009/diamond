<?php
/**
 * Created by JetBrains PhpStorm.
 * User: admin
 * Date: 27.08.12
 * Time: 22:54
 * To change this template use File | Settings | File Templates.
 */

class QueueStateBehavior extends CActiveRecordBehavior {

    private $state;
    public $attributes;

    public function __get($name) {
        if (array_key_exists($name, $this->attributes)) {
            if (is_array($this->state[$this->getOwner()->tableName().$name]) && count($this->state[$this->getOwner()->tableName().$name])) {
                return join(',', $this->state[$this->getOwner()->tableName().$name]);
            } else {
                return "0";
            }
        }
        else {
            return parent::__get($name);
        }
    }

    public function afterSave($event) {
        $this->state = Yii::app()->statePersister->load();
        foreach ($this->attributes as $key => $val) {
            $val = $this->owner[$key];
            if ($val) {
                $this->addKey($this->state[$this->getOwner()->tableName().$key], $this->owner->getPrimaryKey(), $this->attributes[$key]);
            } else {
                $this->removeKey($this->state[$this->getOwner()->tableName().$key], $this->owner->getPrimaryKey());
            }
        }
        Yii::app()->statePersister->save($this->state);
    }

    public function afterDelete($event) {
        $this->state = Yii::app()->statePersister->load();
        foreach ($this->attributes as $key) {
            $this->removeKey($this->state[$this->getOwner()->tableName().$key], $this->owner->getPrimaryKey());
        }
        Yii::app()->statePersister->save($this->state);
    }

    public function afterConstruct($event) {
        $this->state = Yii::app()->statePersister->load();
        foreach ($this->attributes as $key) {
            if (!$this->owner->isNewRecord) {
                if (in_array($this->owner->getPrimaryKey(), $this->state[$key])) {
                    $this->owner[$key] = true;
                } else {
                    $this->owner[$key] = false;
                }
            }
        }
    }

    private function addKey(&$arr, $id, $max) {
        $arr = is_array($arr) ? $arr : array();
        if (!in_array($id, $arr)) {
            array_unshift($arr, $id);
        }
        $arr = array_slice($arr, 0, $max);
    }

    private function removeKey(&$arr, $id) {
        $arr = is_array($arr) ? $arr : array();
        $arr = array_diff($arr, array($id));
    }

}
