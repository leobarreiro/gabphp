<?php
/** 
  * Framework GBAPHP
  * @license : GNU Lesser General Public License v.3
  * @link http://cielnews.com/gba
  * 
  * Classe de Interface HTML para Input com Mascara
  * Utiliza a bilioteca Jquery e o plugin Masked Input 
  * http://jquery.com
  * http://digitalbush.com/projects/masked-input-plugin/
  * 
  * Data de Criacao: 2009-02-02
  * @author Leopoldo Braga Barreiro
  *     
  * @package GBA
  * @subpackage Classes Interface
  *     
  * $Id: $
  *     
  * Casos de uso: 
*/

include_once (GBA_PATH_CLA_INT . 'IInput.class.php');
include_once (GBA_PATH_CLA_INT . 'IScript.class.php');

class IInputMascara extends IInput {
	
	public $stMascara;
	public $stPlaceHolder;
	public $stCompleted;
	public $obJavascript;
	
	/**
	 * Metodo Construtor
	 * @return Void
	 */
	public function IInputMascara($stNomeId='', $stValor='', $inSize=0, $inMaxLength=0) {
		parent::IInput($stNomeId, $stValor, $inSize, $inMaxLength);
		$this->obJavascript = new IScript();
		$this->stPlaceHolder = '';
		$this->stCompleted = '';
		$this->stMascara = '';
	}
	
	public function setMascara($stMascara) { $this->stMascara = $stMascara; }
	public function setPlaceHolder($stPlaceHolder) { $this->stPlaceHolder = $stPlaceHolder; }
	public function setCompleted($stCompleted) { $this->stCompleted = $stCompleted; }
	
	public function getMascara() { return $this->stMascara; }
	public function getPlaceHolder() { return $this->stPlaceHolder; }
	public function getCompleted() { return $this->stCompleted; }
	
	
	public function montaJQueryFuncao() {		
		if (strlen($this->getMascara()) > 0) {
			
			if (strlen($this->getPlaceHolder()) > 0) {
				$stJsFuncao = 'jQuery(function($){$("#' . $this->getId() . '").mask("' . $this->getMascara() . '",{placeholder:"' . $this->getPlaceHolder() . '"});})';
			} else {
				$stJsFuncao = 'jQuery(function($){$("#' . $this->getId() . '").mask("' . $this->getMascara() . '");})';
			}
			$this->obJavascript->addFuncao($stJsFuncao);
		}
	}
	
	
	public function montaHtml() {
		parent::montaHtml();
		$stHtml = $this->getHtml();
		$this->montaJQueryFuncao();
		$this->obJavascript->montaHtml();
		$stHtml .= "\n" . $this->obJavascript->getHtml();		
		$this->stHtml = $stHtml;
	}
	
}


?>