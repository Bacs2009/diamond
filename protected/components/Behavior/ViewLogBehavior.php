<?php

class ViewLogBehavior extends CActiveRecordBehavior
{

	public $alias;
	public $id = 'id';

	public function IsViewLogged()
	{
		$Owner = $this->getOwner();

		if(!$this->alias) $this->alias = $Owner->tableName();
		$ID = $this->id;
		$ID = $Owner->$ID;
		$IP = sprintf('%u', ip2long(Yii::app()->request->userHostAddress));
		$Day = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		return Yii::app()->db->createCommand('INSERT IGNORE INTO view_log (alias,id,ip,day) VALUES(\'' . $this->alias . '\',' . $ID . ',' . $IP . ',' . $Day . ')')->execute();
	}

}

?>