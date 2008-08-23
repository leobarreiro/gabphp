<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Classe de Mapeamento de Tabela: gba_modulo
    * Data de Cria��o: 21/06/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: MPModulo.class.php 51 2008-07-05 06:19:15Z leobba $
    *     
    * Casos de uso : 
*/
include_once( GBA_PATH_CLA_BDA . 'Persistente.class.php' );

class MPModulo extends Persistente {

function MPModulo() {
	parent::Persistente();
	$this->setTabela( GBA_BD_TMODU );
	$this->recuperaCamposTabela();	
}
/**
* @todo implementar consulta para retornar os m�dulos dispon�veis para o usuario
* */
function montaModulosUsuario($inCodUsuario) {
	$stSQL = " SELECT " . $this->getTabela() . "  WHERE codusuario = " . $inCodUsuario . " ";
	return $stSQL;
}

/**
 * @params 	integer inCodUsuario 
 * @desc 	Retorna todos os M�dulos permitidos para determinado Usu�rio
 * @return 	Resource Lista de M�dulos
*/
function modulosUsuario($inCodUsuario) {
	$boRetorno = false;
	if ($inCodUsuario > 0) {
		$stSQL = $this->montaModulosUsuario($inCodUsuario);
		$rsModulos = $this->obConexao->executaSQL($stSQL);
	}
	return $boRetorno;
}

function montaRecuperaPorDiretorio($stDiretorio) {
	$stSQL = "SELECT * FROM `" . $this->getTabela() . "` WHERE diretorio = '" . $stDiretorio . "' ";
	return $stSQL;
}

/**
* @desc 	Retorna os dados do M�dulo de acordo com o diretorio passado por par�metro
* @param 	String Diret�rio do M�dulo
* @return 	Resource Consulta do Banco
* 
* */
function recuperaPorDiretorio($stDiretorio) {
	$stSQL = $this->montaRecuperaPorDiretorio($stDiretorio);
	$this->executaSQL($stSQL);
}

}

?>