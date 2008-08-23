<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Classe de Mapeamento para Tabela gba_funcionalidade
    * Data de Cria��o: 21/06/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: MPFuncionalidade.class.php 51 2008-07-05 06:19:15Z leobba $
    *     
    * Casos de uso : 
*/

include_once( GBA_PATH_CLA_BDA . 'Persistente.class.php' );

class MPFuncionalidade extends Persistente {

function MPFuncionalidade() {
	parent::Persistente();
	$this->setTabela( GBA_BD_TFUNC );
	$this->recuperaCamposTabela();	
}

function montaListaFuncionalidadePorModulo($inCodModulo) {
	if ($inCodModulo > 0) {
		$stSQL = "SELECT * FROM gba_funcionalidade WHERE codmodulo = " . $inCodModulo . " ";
	} else {
		$stSQL = false;
	}
	return $stSQL;
}

/**
* @param 	integer CodModulo
* @return 	resource Consulta Banco
* */
function executaListaFuncionalidadePorModulo($inCodModulo) {
	$roRetorno = false;
	$stSQL = $this->montaListaFuncionalidadePorModulo((integer) $inCodModulo);
	if ($stSQL) {
		$this->roConsulta = $this->obConexao->executaSQL( $stSQL );
		$roRetorno = $this->roConsulta;
	}
	return $roRetorno;
}


}
?>