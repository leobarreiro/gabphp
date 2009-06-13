<?php
/*
 * html.class.php
 * 20/04/2008
*/

include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');
include_once (GBA_PATH_CLA_INT . 'IHead.class.php');
include_once (GBA_PATH_CLA_INT . 'IBody.class.php');

header("Content-Type: text/html; charset=UTF-8",true);

class IHtml extends IComponenteBase {

protected $stDocType;
var $obHead;
var $obBody;
	
function IHtml() {
	$this->setTag('html');
	$this->stDocType = '';
	$this->obHead = new IHead;
	$this->obBody = new IBody;
	//$this->stDocType = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">';
	//<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	//<html xmlns="http://www.w3.org/1999/xhtml">
	//$this->stDocType = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
	$this->stDocType = '';
}

function setDocType($stTag) { $this->stDocType = $stTag; }
function getDocType() { return $this->stDocType; }

function setHead($obHead) { $this->obHead = $obHead; }
function setBody($obBody) { $this->obBody = $obBody; }

function montaHtml() {
	
	$stHtml = $this->getDocType() . "\n";
	
	// abre Tag
	//$stHtml .= '<' . $this->getTag() . ' xmlns="http://www.w3.org/1999/xhtml">' . "\n";
	$stHtml .= '<' . $this->getTag() . '>' . "\n";

	// head
	$this->obHead->montaHtml();
	$stHtml .= $this->obHead->getHtml() . "\n";
	
	//body
	$this->obBody->montaHtml();
	$stHtml .= $this->obBody->getHtml() . "\n";
	
	// fecha tag
	$stHtml .= '</' . $this->getTag() . '>';
	
	$this->stHtml = $stHtml;	
}

}

?>