<?php
/*
 * Lista.class.php
 * 04/01/2008
*/
include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');

class ILista extends IComponenteBase {
		
	var $boOrdenada;
	
	public function ILista()
	{
		parent::IComponenteBase();
		$this->boOrdenada = false;
		$this->stTag = 'ul';
	}
	
	public function setOrdenada($boolean)
	{
		$this->stOrdenada = $boolean;
		if ($boolean)
		{
			$this->setTag('ol');
		}
		else
		{
			$this->setTag('ul');
		}
	}
	
	public function getOrdenada()
	{
		return $this->boOrdenada;
	}
	
	public function montaHtml()
	{
		$stHtml = '<' . $this->getTag();
		if (strlen($this->getId()))
		{
			$stHtml .= ' id="' . $this->getId() . '"';
		}
		if (strlen($this->getCss()))
		{
			$stHtml .= ' class="' . $this->Css() . '"';
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
			$stHtml .= "\n" . '    <li>';
			$obComponente->montaHtml();
			$stHtml .= $obComponente->getHtml();
			$stHtml .= '</li>';
		}	
		$stHtml .= "\n" . '</' . $this->getTag() . '>';	
		$this->stHtml = $stHtml;
	}
}
?>