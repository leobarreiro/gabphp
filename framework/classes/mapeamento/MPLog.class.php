<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Classe de Mapeamento para Tabela gba_log
    * Data de Criaчуo: 06/01/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: $
    *     
    * Casos de uso : 
*/

include_once( GBA_PATH_CLA_BDA . 'Persistente.class.php' );

class MPLog extends Persistente {

function MPLog() {
	parent::Persistente();
	$this->setTabela( GBA_BD_TLOGS );
	$this->recuperaCamposTabela();	
}
	
}

?>