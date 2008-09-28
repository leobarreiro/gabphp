<?php
/**
 	* Framework GBA
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Classe Estática Mensagem
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

require_once( GBA_PATH_CLA . 'Object.class.php' );

class Mensagem extends Object {
	
	public $stAssunto;
	public $stMensagem;
	
	public $stContentType;
	public $stMimeVersion;
	public $stCharset;
	
	public $stEmissorNome;
	public $stEmissorEmail;
	
	public $stReplyNome;
	public $stReplyEmail;
	
	public $stDestinatario;
	public $arCopiaDestinatarios;
	
	/**
	 * Método Construtor
	 */
	public function __construct() {
		
		parent::__construct();
		
		$this->stAssunto = '';
		$this->stMensagem = '';
		
		$this->stMimeVersion = '1.0';
		$this->stContentType = 'text/html';
		$this->stCharset = 'iso-8859-1';
		
		$this->stEmissorNome = '';
		$this->stEmissorEmail = '';
		
		$this->stReplyNome = '';
		$this->stReplyEmail = '';
		
		$this->stDestinatario = '';
		$this->arCopiaDestinatarios = array();

	}
	
	/**
	 * Define o Emissor da Mensagem
	 * @param String Nome do Emissor
	 * @param String E-mail do Emissor
	 */
	public function setEmissor($stNome, $stEmail) { 
		$this->stEmissorNome = $stNome;
		$this->stEmissorEmail = $stEmail;  
	}
	
	/**
	 * Define o Reply da Mensagem
	 * @param String Nome do Reply
	 * @param String E-mail do Reply
	 */
	public function setReply($stNome, $stEmail) { 
		$this->stReplyNome = $stNome;
		$this->stReplyEmail = $stEmail;  
	}
	
	/**
	 * Define o Nome do Emissor Padrão de Mensagens do Site
	 * @param String Nome
	 */
	public function setEmissorNome($stNome) { $this->stEmissorNome = $stNome; }
	
	public function setEmissorEmail($stEmail) { $this->stEmissorEmail = $stEmail; }
	
	public function setReplyNome($stNome) { $this->stReplyNome = $stNome; }
	
	public function setReplyEmail($stEmail) { $this->stReplyEmail = $stEmail; }	
	
	public function setDestinatario($stEmail) { $this->stDestinatario = $stEmail; }
	
	public function setCopiaDestinatarios($arCopiados) { $this->arCopiaDestinatarios = $arCopiados; }
	
	public function setAssunto( $stAssunto ) { $this->stAssunto = $stAssunto; }
	
	public function setMensagem( $stMsg ) { $this->stMensagem = $stMsg; }
	
	public function setMimeVersion( $stMime ) { $this->stMimeVersion = $stMime; }
	
	public function setContentType( $stContentType ) { $this->stContentType = $stContentType; }
	
	public function setCharset( $stCharset ) { $this->stCharset = $stCharset; }
	
	// Métodos GET
	
	public function getDestinatario() { return $this->stDestinatario; }
	
	public function getAssunto() { return $this->stAssunto; }
	
	public function getMensagem() { return $this->stMensagem; }
	
	public function getMimeType() { return $this->stMimeType; }
	
	/**
	 * Adiciona um Destinatario da Mensagem ao Array de Copiados (CC). Retorna true em caso de adicionar, false do contrario.
	 * @param String E-mail
	 * @return boolean
	 */
	public function addCopiaDestinatario( $stEmail ) {
		
		$boRetorno = true;
		$arCopiaDestinatarios = $this->arCopiaDestinatarios;
		
		foreach ($arCopiaDestinatarios as $stEmailExistente) {
			
			if ($stEmail == $stEmailExistente) {
				$boRetorno = false;
				break;
			}
			
		}
		if ($boRetorno) {
			$arCopiaDestinatarios[] = $stEmail;
		}
		
		return $boRetorno;
		
	}
	
	/**
	 * Envia a Mensagem. Retorna true se tudo correr bem, do contrário retorna false.
	 * @param void
	 * @return boolean
	 */
	public function enviar() {
		
		if ($this->getErro()) { return false; }
		
		$stCabecalho = "MIME-Version: " . $this->stMimeVersion . "\r\nContent-type: " . $this->stContentType . "; charset=" . $this->stCharset . "\n";
		$stCabecalho .= "From: '" . $this->stEmissorNome . "' <" . $this->stEmissorEmail . ">\r\n";
		
		$arCopiados = $this->arCopiaDestinatarios;
		
		if (count($arCopiados) > 0) {
			$stCabecalho .= "CC: " . implode(', ', $arCopiados) . "\r\n";
		}
		unset($arCopiados);
		
		$stCabecalho .= "Reply-To: '" . $this->stReplyNome . "' <" . $this->stReplyEmail . ">\r\n";
		$stCabecalho .= 'X-Mailer: PHP/' . phpversion();
		

		$boEnvio = mail($this->getDestinatario(), $this->getAssunto(), $this->getMensagem(), $stCabecalho);
		
		if ($boEnvio) {
			$this->setErro('Mensagem enviada corretamente', false);
		} else {
			$this->setErro('Mensagem não enviada', true);
		}
		
		return $boEnvio;

	}
	
	/**
	 * Retorna um resumo geral da Mensagem
	 * @param void
	 * @return String Resumo Geral
	 */
	public function resumir() {
		
		// @TODO: Aprimorar o Resumo da Mensagem com as informações faltantes
		$stResumo = '';
		$stResumo .= "Destinatario: " . $this->stDestinatario . "<br/>\n";
		$stResumo .= "Copia: " . implode(', ', $this->arCopiaDestinatarios) . "<br/>\n";
		$stResumo .= "Assunto: " . $this->stAssunto . "<br/>\n";
		$stResumo .= "Mensagem: " . $this->stMensagem . "<br/>\n";
		
		return $stResumo;
		
	}
	
}

?>