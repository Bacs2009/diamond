<?php

class OrderingBehavior extends CActiveRecordBehavior
{

	public $field = 'orders';

	public function Ordering()
	{
		if(Yii::app()->request->isAjaxRequest)
		{
			if(isset($_POST['Order']) && is_array($_POST['Order']) && !empty($_POST['Order']))
			{
				$Error = 0;
				$Order = array();
				foreach($_POST['Order'] as $Key => $Value)
				{
					if(!is_numeric($Value) || $Value < 1)
					{
						$Error = 1;
						break;
					}

					$Order[$Value] = $Key + 1;
				}

				if(!$Error)
				{
					$Owner = $this->getOwner();

					foreach($Order as $Key => $Value) $Owner->updateByPk($Key, array($this->field => $Value));

					echo '{"data":"Данные успешно сохранены"}';
				}
				else echo '{"data":"Данные не корректны"}';
			}
			else echo '{"data":"Данные отсутствуют"}';

			Yii::app()->end();
		}
	}

}

?>