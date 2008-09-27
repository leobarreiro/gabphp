<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Classe de Mapeamento para Tabela gba_acao
    * Data de Criação: 21/06/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: MPAcao.class.php 51 2008-07-05 06:19:15Z leobba $
    *     
    * Casos de uso : 
*/

include_once( GBA_PATH_CLA_BDA . 'Persistente.class.php' );

class MPAcao extends Persistente {

function MPAcao() {
	parent::Persistente();
	$this->setTabela( GBA_BD_TACAO );
	$this->recuperaCamposTabela();	
}


function montaListaAcaoPorFuncionalidade($inCodFuncionalidade, $stOrdem) {
	if ($inCodFuncionalidade > 0) {
		$stSQL = "SELECT * FROM gba_acao WHERE codfuncionalidade = " . $inCodFuncionalidade . " ORDER BY " . $stOrdem . " ";
	} else {
		$stSQL = false;
	}
	return $stSQL;
}

/**
* @param 	integer CodFuncionalidade
* @return 	resource Consulta Banco
* */
function executaListaAcaoPorFuncionalidade($inCodFuncionalidade, $stOrdem='ordem') {
	$roRetorno = false;
	$stSQL = $this->montaListaAcaoPorFuncionalidade((integer) $inCodFuncionalidade, $stOrdem);
	if ($stSQL) {
		$this->roConsulta = $this->obConexao->executaSQL( $stSQL );
		$roRetorno = $this->roConsulta;
	}
	return $roRetorno;
}


}
?>