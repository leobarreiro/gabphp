<?
/**
 	* Framework GBA
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Classe Object
    * Data de Criacao: 27/09/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBA
    * @subpackage
    *     
    * $Id: $
    *     
    * Casos de uso : 
*/

class Object {
	
	public $stMsgErro;
	public $boEventoErro;
	
	/**
	 * Método Construtor
	 * @return void
	 */
	public function __construct() {
		$this->stMsgErro = 'Objeto Instanciado: ' . get_class($this);
		$this->boEventoErro = false;
	}
	
	/**
	 * Define Evento de Erro e Mensagem
	 * @param String Mensagem de Erro
	 * @param boolean Evento de Erro
	 * @return void
	 */
	public function setErro($stMsg, $boEvento) {
		$this->boEventoErro = $boEvento;
		$this->stMsgErro = $stMsg;
	}
	
	/**
	 * Retorna Evento de Erro
	 * @return boolean
	 */
	public function getErro() {
		return $this->boEventoErro;
	}
	
	/**
	 * Retorna mensagem de Erro
	 * @return String Mensagem
	 */
	public function getMsgErro() {
		return $this->stMsgErro;
	}
	
}

?>