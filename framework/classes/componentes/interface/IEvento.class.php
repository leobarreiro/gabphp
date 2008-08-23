<?php
/*
 * Evento.class.php
 * 28/12/2007
*/
class IEvento {

var $stOnChange;
var $stOnSelect;
var $stOnClick;
var $stOnLoad;
var $stOnDblClick;
var $stOnBlur;
var $stOnMouseDown;
var $stOnMouseUp;
var $stOnKeyPress;
var $stOnKeyDown;
var $stOnKeyUp;
var $stOnSubmit;
var $stHtml;
	
function setOnChange($valor) { $this->stOnChange = $valor; }
function setOnSelect($valor) { $this->stOnSelect = $valor; }
function setOnClick($valor) { $this->stOnClick = $valor; }
function setOnLoad($valor) { $this->stOnLoad = $valor; }
function setOnDblClick($valor) { $this->stOnDblClick = $valor; }
function setOnBlur($valor) { $this->stOnBlur = $valor; }
function setOnMouseDown($valor) { $this->stMouseDown = $valor; }
function setOnMouseUp($valor) { $this->stOnMouseUp = $valor; }
function setOnKeyPress($valor) { $this->stOnKeyPress = $valor; }
function setOnKeyDown($valor) { $this->stOnKeyDown = $valor; }
function setOnKeyUp($valor) { $this->stOnKeyUp = $valor; }
function setOnSubmit($valor) { $this->stOnSubmit = $valor; }

function getOnChange() { return $this->stOnChange; }
function getOnSelect() { return $this->stOnSelect; }
function getOnClick() { return $this->stOnClick; }
function getOnLoad() { return $this->stOnLoad; }
function getOnDblClick() { return $this->stOnDblClick; }
function getOnBlur() { return $this->stOnBlur; }
function getOnMouseDown() { return $this->stOnMouseDown; }
function getOnMouseUp() { return $this->stOnMouseUp; }
function getOnKeyPress() { return $this->stOnKeyPress; }
function getOnKeyDown() { return $this->stOnKeyDown; }
function getOnKeyUp() { return $this->stOnKeyUp; }
function getOnSubmit() { return $this->stOnSubmit; }

	
function montaHtml() {
	$stHtml = '';
	if (strlen($this->getOnChange())) { $stHtml .= ' onChange="' . $this->getOnChange() . '"'; }
	if (strlen($this->getOnSelect())) { $stHtml .= ' onSelect="' . $this->getOnSelect() . '"'; }
	if (strlen($this->getOnClick())) { $stHtml .= ' onClick="' . $this->getOnClick() . '"'; }
	if (strlen($this->getOnLoad())) { $stHtml .= ' onLoad="' . $this->getOnLoad() . '"'; }
	if (strlen($this->getOnDblClick())) { $stHtml .= ' onDblClick="' . $this->getOnDblClick() . '"'; }
	if (strlen($this->getOnBlur())) { $stHtml .= ' onBlur="' . $this->getOnBlur() . '"'; }
	if (strlen($this->getOnMouseDown())) { $stHtml .= ' onMouseDown="' . $this->getOnMouseDown() . '"'; }
	if (strlen($this->getOnMouseUp())) { $stHtml .= ' onMouseUp="' . $this->getOnMouseUp() . '"'; }
	if (strlen($this->getOnKeyPress())) { $stHtml .= ' onKeyPress="' . $this->getOnKeyPress() . '"'; }
	if (strlen($this->getOnKeyDown())) { $stHtml .= ' onKeyDown="' . $this->getOnKeyDown() . '"'; }
	if (strlen($this->getOnKeyUp())) { $stHtml .= ' onKeyUp="' . $this->getOnKeyUp() . '"'; }
	if (strlen($this->getOnSubmit())) { $stHtml .= ' onSubmit="' . $this->getOnSubmit() . '"'; }
	$this->stHtml = $stHtml;
}

function getHtml() { return $this->stHtml; }

	
}

?>