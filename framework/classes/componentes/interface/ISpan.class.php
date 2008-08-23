<?php
/*
 * Span.class.php
 * 02/02/2008
*/
include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');

class ISpan extends IComponenteBase {

function ISpan($stId='') {
	parent::IComponenteBase();
	$this->setTag('span');
	$this->stId = $stId;
}

}

?>