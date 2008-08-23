<?php
/*
* head.class.php
* 20/04/2008 
*/
include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');

class IHead extends IComponenteBase {

var $arMetaTag;
var $stTitle;
var $stCharset;
var $stUrlCssFile;
var $stUrlJScriptFile;
var $stUrlFavicon; // ícone para a url no browser

/* TODO: implementar favicon para icone de navegador */
// exemplo: <link rel="shortcut icon" type="image/ico" href="http://felipetonello.com/blog/wp-content/themes/road-to-heaven/favicon.png" />

public function IHead($stTitleHead='', $stCharset='ISO-8859-1') {
	parent::IComponenteBase();
	$this->setTag('head');
	$this->arMetaTag = array();
	$this->stTitle = $stTitleHead;
	$this->stCharset = $stCharset;
	$this->stUrlCssFile = '';
	$this->stUrlJScriptFile = '';
	$this->stUrlFavicon = '';
	
	// leave this for stats please
	// por favor mantenha esta meta tag para estatisticas
	$this->addMetaTag('generator', GBA_VERSION);
	
}

function setTitle($stTitleHead) { $this->stTitle = $stTitleHead; }
function setCharset($stCharset) { $this->stCharset = $stCharset; }
function setUrlCssFile($stUrlCssFile) { $this->stUrlCssFile = $stUrlCssFile; }
function setUrlJScriptFile($stUrlJScriptFile) { $this->stUrlJScriptFile = $stUrlJScriptFile; }
function setUrlFavicon($stUrlFavicon) { $this->stUrlFavicon = $stUrlFavicon; }

function getTitle() { return $this->stTitle; }
function getCharset() { return $this->stCharset; }
function getUrlCssFile() { return $this->stUrlCssFile; }
function getUrlJScriptFile() { return $this->stUrlJScriptFile; }
function getUrlFavicon() { return $this->stUrlFavicon; }

function addMetaTag($stNome, $stValor) {
	$arMetaTag = $this->arMetaTag;
	$arMetaTag[] = array('name'=>$stNome, 'content'=>$stValor);
	$this->arMetaTag = $arMetaTag;	
}

function montaHtml() {

	$stHtml = '<' . $this->getTag() . '>' . "\n";
	$stHtml .= '	<meta http-equiv="Content-Type" content="text/html; charset=' . $this->getCharset() . '" />' . "\n";

	if (strlen($this->getTitle())) {
		$stHtml .= '	<title>' . $this->getTitle() . '</title>' . "\n";
	}
	
	foreach ($this->arMetaTag as $arMeta) {
		$stHtml .= '	<meta name="' . $arMeta['name'] . '" content="' . $arMeta['content'] .'" />' . "\n";
	}
	
	if (strlen($this->getUrlCssFile())) {
		$stHtml .= '	<link href="' . $this->getUrlCssFile() . '" rel="styleSheet" type="text/css" />' . "\n";
	}
	
	if (strlen($this->getUrlJScriptFile())) {
		$stHtml .= '	<script type="text/javascript" src="' . $this->getUrlJScriptFile() . '" />' . "\n";
	}
	
	if (strlen($this->getUrlFavicon())) {
		$stHtml .= '<link rel="shortcut icon" type="image/ico" href="' . $this->getUrlFavicon() . '" />' . "\n";
		
	}
	
	$stHtml .= '</' . $this->getTag() . '>';
	
	$this->stHtml = $stHtml;
	
}

}
?>