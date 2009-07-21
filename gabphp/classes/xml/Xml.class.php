<?php
/**
* Xml.class.php
* 2008-05-01
* 
* Nota: Esta classe utiliza os recursos da biblioteca DOM do PHP5 
*/

class Xml {
	
	protected $obDom;
	protected $xmlPath;
	protected $xmlContent;
	protected $arError;
	protected $error;
	protected $errorCode;
	protected $stHtml;
	
	public function Xml($xmlPath=null) {
		
		$this->obDom = new DOMDocument();
		$this->error = null;
		$this->arError = array(	0=>'Sem erro', 
								1=>'Arquivo XML não definido', 
								2=>'Arquivo XML não encontrado', 
								3=>'Arquivo XML não carregado', 
								4=>'Arquivo XML não validado' );
		
		$this->openXml($xmlPath);
	}
	
	function getXmlPath() { return $this->xmlPath; }
	function getXmlContent() { return $this->xmlContent; }	
	function getDom() { return $this->obDom; }
	
	function setXmlPath($xmlPath) { $this->xmlPath = $xmlPath; }	
	function setXmlContent($xmlContent) { $this->xmlContent = $xmlContent; }
	
	
	function openXml($xmlPath=null) {		
		
		if ( $xmlPath != null && strlen($xmlPath) ) {
			if (file($xmlPath)) {				
				$this->setXmlPath($xmlPath);				
				if ( $this->obDom->load($xmlPath, LIBXML_ERR_NONE) ) {									
					$this->setXmlContent($this->obDom->saveXml());
					$this->setError(0);
				} else {
					$this->setXmlContent(null);
					$this->setError(3);					
				}
			} else {
				$this->setXmlContent(null);
				$this->setError(2);
			}			
		} else {
			$this->setXmlPath(null);
			$this->setXmlContent(null);
			$this->setError(1);
		}
	}
	
	
	function setError($inError=0) {
		$arErrMsg = $this->arError;
		if (isset($arErrMsg[$inError])) {
			$this->error = $arErrMsg[$inError];
			$this->errorCode = $inError;
		}
		unset($arErrMsg);
	}
	
	// M�todos para compatibilidade com classes de componentes HTML
	function montaHtml() { 
		
		$arRetira = array('<?xml version="1.0" encoding="ISO-8859-1"?>', '<?xml version="1.0" encoding="UTF-8"?>');
		$arSubst  = array('', '');
		
		$stHtml = str_replace($arRetira, $arSubst, $this->getXmlContent());
		
		$this->stHtml = $stHtml;
		unset($stHtml);
	}
	
	function getErrorCode() { return $this->errorCode; }	
	function getError() { return $this->error; }
	
	function getHtml() { return $this->stHtml; }	
	function show() { echo $this->xmlContent; }
	
}
?>