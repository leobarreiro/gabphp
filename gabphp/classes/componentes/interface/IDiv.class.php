<?php
/*
 * Div.class.php
 * 29/12/2007
*/
include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');
include_once (GBA_PATH_CLA_INT . 'IEvento.class.php');

class IDiv extends IComponenteBase {

	public function IDiv($stId='')
	{
		parent::IComponenteBase();
		$this->setTag('div');
		$this->stId = $stId;
	}
}
?>