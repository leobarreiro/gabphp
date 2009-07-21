<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Classe de Mapeamento para Tabela gba_empresa_modulo
    * Data de Criaчуo: 21/06/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: MPEmpresaModulo.class.php 17 2008-06-24 01:03:26Z leobba $
    *     
    * Casos de uso : 
*/

include_once( GBA_PATH_CLA_BDA . 'Persistente.class.php' );

class MPEmpresaModulo extends Persistente {

function MPEmpresaModulo() {
	parent::Persistente();
	$this->setTabela( GBA_BD_TEMMO );
	$this->recuperaCamposTabela();	
}

}
?>