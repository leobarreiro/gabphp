<?php
/**
 	* Framework GBA
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Classe Estatica de Administracao de Sessao
    * Data de Criacao: 14/11/2006
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: $
    *     
    * Casos de uso : 
*/

include_once ( GBA_PATH_CLA . 'Object.class.php');
include_once ( GBA_PATH_ENV . 'LoadDefs.php');

class Sessao extends Object {
	
	/**
	* Controla a Autenticacao de Usuario no Sistema. Deve ser chamado no inicio de cada pagina.
	* @param 	void
	* @return 	void
	*/	
	public function controle() {
        
		if (isset($_COOKIE[GBA_COOKIE_NAME])) {
			session_name(GBA_COOKIE_NAME);
			session_start();	
		}
		if (isset($_SESSION) && isset($_SESSION['sessao']) && isset($_SESSION['sessao']['codsessao'])) {
			$boAutenticado = true;
		} else {
			$boAutenticado = false;
		}
		if ($boAutenticado === false) {
			header("Location: " . GBA_URL_SISTEMA . "login.php");
		}
		
        // Adiciona registro no Historico de navegacao
        // Verificando se a ultima pagina ja nao esta gravada

		$stUltimaPagina = str_replace(GBA_PATH_SISTEMA, '', $_SERVER['SCRIPT_FILENAME']);

		if (count($_SESSION['historico']) == 0) {
				$_SESSION['historico'][] = $stUltimaPagina;
		} else {
				if ( isset($_SESSION['historico'][count($_SESSION['historico'])-1]) && ($_SESSION['historico'][count($_SESSION['historico'])-1] != $stUltimaPagina) ) {
						$_SESSION['historico'][] = $stUltimaPagina;
				}
		}
        
	}
	
	public function fecha() {
		
		session_name(GBA_COOKIE_NAME);
		if (!isset($_SESSION)) {
			session_start();
		}
		$boRetorno = false;
		
		include_once ( GBA_PATH_CLA_EST . 'Cookie.class.php' );
		include_once ( GBA_PATH_CLA_EST . 'FusoHorario.class.php' );
		include_once ( GBA_PATH_CLA_MAP . 'MPSessao.class.php' );
	
		$obFuso = new FusoHorario;
		$obFuso->setFuso( GBA_FUSO_HORARIO );
		$obFuso->setFormatoData("Y-m-d");
		$obFuso->setFormatoHora("H:i:s");
		$obFuso->calculaDataHoraLocal();		
		
		if (isset($_SESSION['sessao']) && isset($_SESSION['sessao']['codsessao'])) {
			$obMPSessao = new MPSessao;
			$obMPSessao->addValor('codsessao', $_SESSION['sessao']['codsessao']);
			$obMPSessao->addValor('ativa', 0);
			$obMPSessao->addValor('datafim', $obFuso->getDataLocal());
			$obMPSessao->addValor('horafim', $obFuso->getHoraLocal());
			$obMPSessao->alterar();
		
			session_name(GBA_COOKIE_NAME);
			$boRetorno = session_destroy();
		}
		return $boRetorno;
	}
	
	public function abre( $stUsuario, $stSenha ) {
	
		$boRetorno = false;
		
		require_once ( GBA_PATH_CLA_EST . 'Cookie.class.php' );
		require_once ( GBA_PATH_CLA_EST . 'FusoHorario.class.php' );
		require_once ( GBA_PATH_CLA_MAP . 'MPSessao.class.php' );
		require_once ( GBA_PATH_CLA_MAP . 'MPUsuario.class.php' );
		require_once ( GBA_PATH_CLA_BDA . 'RecordSet.class.php' );	
		
		$obMPUsuario = new MPUsuario;
		$obMPUsuario->addValor( 'nomeusuario', strip_tags($stUsuario) );
		$obMPUsuario->addValor( 'senhausuario', md5(strip_tags($stSenha)) );
		$obMPUsuario->recuperar();
		
		if ( $obMPUsuario->getRegSelecionados() > 0 ) {
			
			$rsUsuario = new RecordSet;
			$rsUsuario->setResultados($obMPUsuario->getConsulta());
			
			$obFuso = new FusoHorario;
			$obFuso->setFormatoData("Y-m-d");
			$obFuso->setFormatoHora("H:i:s");
			$obFuso->calculaDataHoraLocal();
			
			$obMPSessao = new MPSessao;
			$obMPSessao->addValor('codusuario', $rsUsuario->getValor('codusuario'));
			$obMPSessao->addValor('ip', $_SERVER['REMOTE_ADDR']);
			$obMPSessao->addValor('datainicio', $obFuso->getDataLocal());
			$obMPSessao->addValor('horainicio', $obFuso->getHoraLocal());
			$obMPSessao->addValor('datafim', 'NULL');
			$obMPSessao->addValor('horafim', 'NULL');
			$obMPSessao->addValor('ativa', 1);
			
			// Encerra todas as Sessoes do Usuario
			$obMPSessao->encerraSessoesUsuario((integer) $rsUsuario->getValor('codusuario'));		
			
			$obMPSessao->incluir();
			
			if ($obMPSessao->getRegAfetados() > 0) {
				// Cria a Sessao
				if (!isset($_SESSION)) {
					session_name(GBA_COOKIE_NAME);
					session_start();
				}			
				// Inicializa Valores da Sessao		
				$_SESSION['sessao'] = array();			
				$_SESSION['sessao']['codsessao'] = $obMPSessao->getInsertId(); 
				$_SESSION['sessao']['codusuario'] = $rsUsuario->getValor('codusuario');
				$_SESSION['sessao']['nomeusuario'] = $rsUsuario->getValor('nomeusuario');
				$_SESSION['sessao']['senhausuario'] = $rsUsuario->getValor('senhausuario');
				$_SESSION['sessao']['nomecompleto'] = $rsUsuario->getValor('nomecompleto');
				$_SESSION['sessao']['email'] = $rsUsuario->getValor('email');
				$_SESSION['sessao']['telefone'] = $rsUsuario->getValor('telefone');
				$_SESSION['sessao']['celular'] = $rsUsuario->getValor('celular');
				$_SESSION['sessao']['administrador'] = $rsUsuario->getValor('administrador');
				$_SESSION['sessao']['agendaempresa'] = $rsUsuario->getValor('agendaempresa');
				$_SESSION['sessao']['datainicio'] = $obMPSessao->getValor('datainicio');
				$_SESSION['sessao']['horainicio'] = $obMPSessao->getValor('horainicio');
				$_SESSION['sessao']['timestamp'] = $obFuso->getTimeStampLocal();
				
				$_SESSION['msg'] = array();
				$_SESSION['msg'][] = "Login efetuado com sucesso";

                $_SESSION['titulo'] = '';
				$_SESSION['historico'] = array();
				
				$_SESSION['pesquisa'] = array();
				
				$_SESSION['env'] = array();
				$_SESSION['env']['urlBaseSistema'] = 'http://' . $_SERVER['HTTP_HOST'] . substr($_SERVER['SCRIPT_NAME'], 0, (strrpos($_SERVER['SCRIPT_NAME'], '/')+1));
				$_SESSION['env']['pathBaseSistema'] = substr($_SERVER['SCRIPT_FILENAME'], 0, (strrpos($_SERVER['SCRIPT_FILENAME'], '/')+1));
			}
		}
	
		return $boRetorno;
	
	}
	
	/**
	 * Grava uma Mensagem do Sistema na Sessao
	 * @param String Mensagem
	 * @return Boolean
	 */ 
	public function gravarMensagem($stMsg) {
		
		if (!isset($_SESSION)) {
			$this->setErro('Sessão não criada ao tentar registrar Mensagem', true);
			return false;
		}
		
		$arMsgSessao = $_SESSION['msg'];
		$arMsgSessao[] = $stMsg;
		$_SESSION['msg'] = $arMsgSessao;
		return true;
		
	}

    /**
	 * Retorna a ultima mensagem gravada na Sessao
	 * @param void
	 * @return String Mensagem
	 */ 
    public function mostraUltimaMensagem() {
        
        $arMsgSessao = $_SESSION['msg'];
        $stUltimaMensagem = $arMsgSessao[count($arMsgSessao)-1];
        return $stUltimaMensagem;

    }
	
	/**
	 * Grava na Sessao o Titulo de Pagina
	 * @param String Titulo
	 */ 
	public function gravarTituloPagina($stTitulo) {

		if (!isset($_SESSION)) {
			$this->setErro('Sessão não criada ao tentar gravar Título de Página', true);
            return false;
		}
        $_SESSION['titulo'] = $stTitulo;
        return true;

	}

	/**
	 * Recupera da Sessao o Titulo de Pagina previamente gravado
	 * @param void
	 * @return String Titulo de Pagina
	 */ 
	public function recuperarUltimoTituloPagina() {
		
		if (!isset($_SESSION['titulo'])) {
			return false;
		}
		return $_SESSION['titulo'];
	
	}
	
	/**
	 * Grava o Conteudo de um RecordSet na Sessao
	 * @param String Nome do RecordSet
	 * @param RecordSet Object
	 * @return boolean
	 */ 
	public function gravarRecordSet($stNome, $obRecordSet) {
		
		$_SESSION['pesquisa'][$stNome] = $obRecordSet;
		return true;
		
	}
	
	/**
	 * Recupera o RecordSet na Sessão, identificado por stNome
	 * @param String Nome do Recordset
	 * @return RecordSet Object
	 */ 
	public function recuperarRecordSet($stNome) {
		
		if (isset($_SESSION['pesquisa'][$stNome])) {
			return $_SESSION['pesquisa'][$stNome];
		} else {
			return false;
		}
		
	}

}
?>