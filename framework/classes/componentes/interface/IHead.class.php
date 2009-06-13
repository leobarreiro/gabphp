<?php
/*
* head.class.php
* 20/04/2008 
*/
include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');

class IHead extends IComponenteBase
{

public $arMetaTag;
public $stTitle;
public $stCharset;
public $stUrlCssFile;
public $stUrlFavicon; // Icone para a url no browser
public $arJSArquivo; 	// Array de Arquivos Javascript para inclusão no Cabecalho

/* TODO: implementar favicon para icone de navegador */
// exemplo: <link rel="shortcut icon" type="image/ico" href="http://felipetonello.com/blog/wp-content/themes/road-to-heaven/favicon.png" />

/**
 * Método Construtor
 * @param $stTitleHead String
 * @param $stCharset String
 * @return voif
 */
public function IHead($stTitleHead='', $stCharset='UTF-8')
{
	parent::IComponenteBase();
	$this->setTag('head');
	$this->arMetaTag = array();
	$this->arJSArquivo = array();
	$this->arCSSArquivo = array();
	$this->stTitle = $stTitleHead;
	$this->stCharset = $stCharset;
	$this->stUrlCssFile = '';
	$this->stUrlFavicon = '';
	$this->addMetaTag('generator', GBA_VERSION);
}

public function setTitle($stTitleHead)
{
	$this->stTitle = $stTitleHead;
}

public function setCharset($stCharset)
{
	$this->stCharset = $stCharset;
}
public function setUrlFavicon($stUrlFavicon)
{
	$this->stUrlFavicon = $stUrlFavicon;
}

/**
 * Adiciona um Arquivo externo do tipo Javascript ao Head
 * @param String URL do Arquivo JS
*/
public function addJSArquivo($stArquivoJS)
{	
	$arArquivoJS = $this->arJSArquivo;
	$arArquivoJS[] = $stArquivoJS;
	$this->arJSArquivo = $arArquivoJS;
	return true;
}

/**
 * Adiciona um Arquivo externo do tipo CSS ao Head
 * @param String URL do Arquivo CSS
*/
public function addCSSArquivo($stArquivoCSS)
{	
	$arArquivoCSS = $this->arCSSArquivo;
	$arArquivoCSS[] = $stArquivoCSS;
	$this->arCSSArquivo = $arArquivoCSS;
	return true;
}

public function getTitle()
{
	return $this->stTitle;
}

public function getCharset()
{
	return $this->stCharset;
}

public function getUrlFavicon()
{
	return $this->stUrlFavicon;
}

public function addMetaTag($stNome, $stValor)
{
	$arMetaTag = $this->arMetaTag;
	$arMetaTag[] = array('name'=>$stNome, 'content'=>$stValor);
	$this->arMetaTag = $arMetaTag;	
}

public function montaHtml()
{
	$stHtml = '<' . $this->getTag() . '>' . "\n";
	//$stHtml .= '	<meta http-equiv="Content-Type" content="text/html; charset=' . $this->getCharset() . '" />' . "\n";
	if (strlen($this->getTitle()))
	{
		$stHtml .= '	<title>' . $this->getTitle() . '</title>' . "\n";
	}
	foreach ($this->arMetaTag as $arMeta)
	{
		$stHtml .= '	<meta name="' . $arMeta['name'] . '" content="' . $arMeta['content'] .'" />' . "\n";
	}
	$arArquivoJS = $this->arJSArquivo;
	foreach ($arArquivoJS as $stJs)
	{
		$stHtml .= '	<script type="text/javascript" src="' . $stJs . '"></script>' . "\n";
	}
	$arArquivoCSS = $this->arCSSArquivo;
	foreach ($arArquivoCSS as $stCSS)
	{
		$stHtml .= '	<link href="' . $stCSS . '" rel="styleSheet" type="text/css" />' . "\n";
	}
	if (strlen($this->getUrlFavicon()))
	{
		$stHtml .= '<link rel="shortcut icon" type="image/ico" href="' . $this->getUrlFavicon() . '" />' . "\n";	
	}
	$stHtml .= '</' . $this->getTag() . '>';
	$this->stHtml = $stHtml;
}

}
?>