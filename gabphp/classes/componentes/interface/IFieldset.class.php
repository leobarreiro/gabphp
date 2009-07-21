<?php
/** 
  * Framework GBAPHP
  * @license : GNU Lesser General Public License v.3
  * @link http://cielnews.com/gba
  * 
  * Classe de Interface HTML para Input de Cifras 
  * Data de Criacao: 2009-02-21
  * @author Leopoldo Braga Barreiro
  *     
  * @package GBA
  * @subpackage Classes Interface
  *     
  * $Id: $
  *     
  * Casos de uso: 
*/

include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');

class IFieldset extends IComponenteBase {
	
	public $stLegend;
	
	/**
	 * Metodo Construtor
	 * @param $stLegend
	 * @return void
	 */
	public function IFieldset($stLegend='') {
		parent::IComponenteBase();
		$this->stLegend = $stLegend;
		$this->stTag = 'fieldset';
	}
	
	/**
	 * Define o texto que aparece na tag Legend 
	 * @param $stLegend
	 * @return void
	 */
	public function setLegend($stLegend='') {
		$this->stLegend = $stLegend;
	}
	
	/**
	 * Retorna o texto da tag Legend
	 * @return String
	 */
	public function getLegend() {
		return $this->stLegend;
	}
	
	/**
	 * Metodo sobrecarregado para Criar HTML
	 * @return void
	 */
	public function montaHtml() {
		
		$stHtml = "\n" . '<' . $this->getTag();
		
		if (strlen($this->getNome())) {
			$stHtml .= ' name="' . $this->getNome() . '"';
		}
		if (strlen($this->getId())) {
			$stHtml .= ' id="' . $this->getId() . '"';
		}
		if (strlen($this->getCss())) {
			$stHtml .= ' class="' . $this->getCss() . '"';
		}
		if (strlen($this->getStyle())) {
			$stHtml .= ' style="' . $this->getStyle() . '"';
		}
		if (strlen($this->getTitle())) {
			$stHtml .= ' title="' . $this->getTitle() . '"';
		}	
		
		$this->obEvento->montaHtml();
		$stHtml .= $this->obEvento->getHtml();
		
		$stHtml .= '>';
		
		if (strlen($this->stLegend) > 0) {
			$stHtml .= '<legend>' . $this->stLegend . '</legend>';
		}
		
		foreach ($this->arComponente as $obComponente) {
			
			$obComponente->montaHtml();
			$stHtml .= $obComponente->getHtml();
			
		}
			
		$stHtml .= '</' . $this->getTag() . '>';
		$this->stHtml = $stHtml;
		 
	}

}

?>