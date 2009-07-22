<?
/**
 	* Framework GabPhp
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gab
    * 
    * Classe Object
    * Data de Criacao: 27/09/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package GabPhp
    * @subpackage gabphp
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
	public function __construct()
	{
		$this->stMsgErro = 'Objeto Instanciado: ' . get_class($this);
		$this->boEventoErro = false;
	}
	
	/**
	 * Define Evento de Erro e Mensagem
	 * @param String Mensagem de Erro
	 * @param boolean Evento de Erro
	 * @return void
	 */
	public function setErro($stMsg, $boEvento)
	{
		$this->boEventoErro = $boEvento;
		$this->stMsgErro = $stMsg;
	}
	
	/**
	 * Retorna Evento de Erro
	 * @return boolean
	 */
	public function getErro()
	{
		return $this->boEventoErro;
	}
	
	/**
	 * Retorna mensagem de Erro
	 * @return String Mensagem
	 */
	public function getMsgErro()
	{
		return $this->stMsgErro;
	}
	
	
	public function logError()
	{
		$this->logMsg($this->stMsgErro);
	}
	
	/**
	 * Realiza o Log de uma mensagem
	 * @param String $msg Mensagem a ser incluida no log
	 * @return boolean
	 */
	public function logMsg($msg)
	{
		$stMensagemLog = "[" . date("Y-m-d H:i:s") . "] " . get_class($this) . " - " . $msg . "<br/>\n";
		error_log($stMensagemLog, 3, GBA_LOG_FILE);
		return true;
	}
}
?>