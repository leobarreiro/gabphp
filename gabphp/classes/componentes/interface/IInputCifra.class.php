<?php
/** 
  * Framework GBAPHP
  * @license : GNU Lesser General Public License v.3
  * @link http://cielnews.com/gba
  * 
  * Classe de Interface HTML para Input de Cifras 
  * Data de Criacao: 2009-01-25
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

class IInputCifra extends IInput {
	
	public $obInputMoeda;
	public $obInputNumero;
	public $stTipoMoeda;
	public $flValorNumero;	
	/**
	 * Metodo Construtor
	 * @return Void
	 */
	public function IInputCifra() {
		$this->obInputMoeda = new IInput;
		$this->obInputMoeda->stType = 'text';
		$this->obInputMoeda->setReadOnly(true);
		$this->obInputMoeda->setDisabled(true);
		$this->obInputMoeda->setMaxLength(2);		
		$this->obInputMoeda->setSize(2);
		$this->obInputMoeda->setValue('R$');
		$this->obInputMoeda->setCss('InpMoeda');
		
		$this->obInputNumero = new IInput;
		$this->obInputNumero->stType = 'text';
		$this->obInputNumero->setMaxLength(12);		
		$this->obInputNumero->setSize(12);
		$this->obInputNumero->setValue('0,00');
		$this->obInputNumero->setCss('InpCifra');
		$this->obInputNumero->obEvento->setOnKeyPress('return(MascaraMoeda(this,\'.\',\',\',event))');
	}
	
	/**
	 * Define o Estilo CSS do Input Numerico
	 * @param $stCss
	 * @return Void
	 */
	public function setCssNumero($stCss) {
		$this->stCssNumero = $stCss;
		$this->obInputNumero->setCss($stCss);
	}

	/**
	 * Define o Estilo CSS do Input somente leitura Moeda
	 * @param $stCss
	 * @return unknown_type
	 */
	public function setCssMoeda($stCss) {
		$this->stCssMoeda($stCss);
		$this->obInputMoeda->setCss($stCss);
	}
	
	/**
	 * Define o Nome e o ID do Campo Numerico
	 * @param $stNome
	 * @return Void
	 */
	public function setNomeCampo($stNome) {
		$this->obInputNumero->setNomeId($stNome);
	}
	
	/**
	 * Retorna o Estilo CSS do Input Numerico
	 * @return String CSS Input Numero
	 */
	public function getCssNumero() {
		return $this->stCssNumero;
	}
	
	/**
	 * Retorna o Estilo CSS do Input Moeda
	 * @return String CSS Input Moeda
	 */
	public function getCssMoeda() {
		return $this->obInputMoeda->getCss();
	}
	
	/**
	 * Define o numero maximo de caracteres do input numerico
	 * @param Integer $inMax
	 * @return Void
	 */
	public function setMaxInputNumero($inMax) {
		$this->obInputNumero->setMaxLength((string)$inMax);
	}
	
	/**
	 * Define o Valor do Input numerico
	 * @param $flNumero
	 * @return Void
	 */
	public function setValorNumero($flNumero) {
		$this->obInputNumero->setValue($flNumero);
	}
	
	/**
	 * Define o Tipo de Moeda do input moeda
	 * @param $stMoeda
	 * @return Void
	 */
	public function setTipoMoeda($stMoeda) {
		$this->obInputMoeda->setValue($stMoeda);		
	}
	
	public function montaHtml() {
		$this->obInputMoeda->montaHtml();
		$stHtml  = $this->obInputMoeda->getHtml();
		
		$this->obInputNumero->montaHtml();
		$stHtml .= $this->obInputNumero->getHtml();
		$this->stHtml = $stHtml;
	}
	
}


?>