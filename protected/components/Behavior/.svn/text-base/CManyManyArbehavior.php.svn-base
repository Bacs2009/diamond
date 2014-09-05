<?php

class CManyManyArbehavior extends CActiveRecordBehavior {
    public $fields = array();
    private $data = array();
    private $forsave = array();

    public function afterSave($event) {
        $relations = $this->getRelations();
        foreach ($this->forsave as $name => $v) {
            Yii::app()->db->createCommand("
                DELETE FROM {$relations[$name]['m2mTable']} WHERE {$relations[$name]['m2mTable']}.{$relations[$name]['m2mThisField']} = {$this->owner->getPrimaryKey()}
            ")->execute();
            if (is_array($v)) {
                foreach ($v as $id) {
                    Yii::app()->db->createCommand("
                   INSERT IGNORE INTO {$relations[$name]['m2mTable']}({$relations[$name]['m2mThisField']},{$relations[$name]['m2mForeignField']}) VALUES ({$this->owner->getPrimaryKey()},{$id});
                ")->execute();
                }
            }
        }
    }

    public function setAllRelated($name, $val) {
        $name = strtolower($name);
        $this->forsave[$name] = $val;
    }

    public function getAllRelated($name) {
        $name = strtolower($name);
        if (!array_key_exists($name, $this->data)) {
            $this->getData($name);
        }
        return $this->data[$name]['all'];
    }

    public function getSelectedRelated($name) {
        $name = strtolower($name);
        if (!array_key_exists($name, $this->data)) {
            $this->getData($name);
        }
        return isset($this->data[$name]['selected']) ? $this->data[$name]['selected'] : array();
    }

    private function getData($name) {
        $name = strtolower($name);
        $relations = $this->getRelations();

        if (array_key_exists($name, $relations)) {
            $programId = (int)$this->owner->getPrimaryKey();
            $data = Yii::app()->db->createCommand("
                SELECT id,
                       {$this->fields[$name]},
                       EXISTS (SELECT *
                               FROM   {$relations[$name]['m2mTable']}
                               WHERE   {$relations[$name]['m2mTable']}.{$relations[$name]['m2mThisField']} = {$programId}
                                  AND  {$relations[$name]['m2mTable']}.{$relations[$name]['m2mForeignField']} = {$relations[$name]['foreignTable']}.id) as val
                FROM    {$relations[$name]['foreignTable']};
            ")->queryAll();
            $res = array();
            $selected = array();
            foreach ($data as $v) {
                $res[$v['id']] = $v[$this->fields[$name]];
                if ($v['val']) {
                    $selected[] = $v['id'];
                }
            }
            $this->data[$name]['all'] = $res;
            $this->data[$name]['selected'] = $selected;
        } else {
            $this->data[$name]['all'] = array();
        }
    }

    protected function getRelations() {
        $relations = array();

        foreach ($this->owner->relations() as $key => $relation)
        {
            if ($relation[0] == CActiveRecord::MANY_MANY &&
                //$this->owner->hasRelated($key) &&
                $this->owner->$key != -1
            ) {
                $info = array();
                $info['key'] = $key;
                $info['foreignTable'] = strtolower($relation[1]);

                if (preg_match('/^(.+)\((.+)\s*,\s*(.+)\)$/s', $relation[2], $pocks)) {
                    $info['m2mTable'] = strtolower($pocks[1]);
                    $info['m2mThisField'] = strtolower($pocks[2]);
                    $info['m2mForeignField'] = strtolower($pocks[3]);
                }
                else
                {
                    $info['m2mTable'] = strtolower($relation[2]);
                    $info['m2mThisField'] = $this->owner->tableSchema->PrimaryKey;
                    $info['m2mForeignField'] = CActiveRecord::model($relation[1])->tableSchema->primaryKey;
                }
                $relations[$key] = $info;
            }
        }
        return $relations;
    }
}
