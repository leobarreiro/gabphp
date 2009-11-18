<?php
/**
 	* Framework GabPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.leopoldobarreiro.com/gabphp
    * 
    * Classe de Componente Basico para Interface HTML
    * Data de Criacao: 28/12/2007
    * @author Leopoldo Braga Barreiro
    *     
    * @package GABPHP
    * @subpackage
    *     
    * $Id: $
    *     
    * Casos de uso : 
*/

include_once( GBA_PATH_CLA . 'Object.class.php' );
include_once (GBA_PATH_CLA_INT . 'IEvento.class.php');

class IComponenteBase extends Object {
	
	var $stTag;
	var $stNome;
	var $stId;
	var $stType;
	var $obEvento;
	var $arComponente; // array de Objetos contidos
	var $stCss;
	var $stStyle;
	var $stTitle;
	var $stHtml;
	
	
	public function IComponenteBase()
	{
		parent::__construct();
		$this->stCss = '';
		$this->stStyle = '';
		$this->stHtml = '';
		$this->obEvento = new IEvento;
		$this->arComponente = array();
	}
	
	public function setTag($string)
	{
		$this->stTag = $string;
	}
	
	public function setNome($valor)
	{
		$this->stNome = $valor;
	}
	
	public function setId($valor)
	{
		$this->stId = $valor;
	}
	
	public function setNomeId($string)
	{
		$this->stNome = $string; $this->stId = $string;
	}
	
	public function setType($valor)
	{
		$this->stType = $valor;
	}
	
	public function setCss($valor)
	{
		$this->stCss = $valor;
	}
	
	public function setStyle($valor)
	{
		$this->stStyle = $valor;
	}
	
	public function setTitle($stTitle)
	{
		$this->stTitle = $stTitle;
	}
	
	public function getTag()
	{
		return $this->stTag;
	}
	
	public function getNome()
	{
		return $this->stNome;
	}
	
	public function getId()
	{
		return $this->stId;
	}
	
	public function getType()
	{
		return $this->stType;
	}
	
	public function getCss()
	{
		return $this->stCss;
	}
	
	public function getStyle()
	{
		return $this->stStyle;
	}
	
	public function getTitle()
	{
		return $this->stTitle;
	}
	
	public function addComponente($mixedComponente)
	{
		if (is_object($mixedComponente))
		{
			$this->arComponente[] = $mixedComponente;	
		}
		elseif (is_array($mixedComponente))
		{
			foreach ($mixedComponente as $obComponente)
			{
				$this->arComponente[] = $obComponente;
			}
		}
	}
	
	public function add($mixedComponente)
	{
		$this->addComponente($mixedComponente);
	}
	
	// Metodo Base para Implementacao Especialista
	public function montaHtml()
	{
		$stHtml = "\n" . '<' . $this->getTag();
		if (strlen($this->getNome()))
		{
			$stHtml .= ' name="' . $this->getNome() . '"';
		}
		if (strlen($this->getId()))
		{
			$stHtml .= ' id="' . $this->getId() . '"';
		}
		if (strlen($this->getCss()))
		{
			$stHtml .= ' class="' . $this->getCss() . '"';
		}
		if (strlen($this->getStyle()))
		{
			$stHtml .= ' style="' . $this->getStyle() . '"';
		}
		if (strlen($this->getTitle()))
		{
			$stHtml .= ' title="' . $this->getTitle() . '"';
		}	
		
		$this->obEvento->montaHtml();
		$stHtml .= $this->obEvento->getHtml();
		
		$stHtml .= '>';
		
		foreach ($this->arComponente as $obComponente)
		{
			$obComponente->montaHtml();
			$stHtml .= $obComponente->getHtml();
		}
			
		$stHtml .= '</' . $this->getTag() . '>';
		$this->stHtml = $stHtml; 
	}
	
	// Metodo Padrao para imprimir HTML
	public function getHtml()
	{
		return $this->stHtml;
	}
	
	public function show()
	{
		$this->montaHtml(); 
		echo $this->stHtml;
	}
	
	function renderizar()
	{
		$this->show();
	}
}
?>