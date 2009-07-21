<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Classe de Mapeamento para Tabela gba_usuario_acao
    * Data de Criaчуo: 21/06/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: MPUsuarioAcao.class.php 17 2008-06-24 01:03:26Z leobba $
    *     
    * Casos de uso : 
*/

include_once( GBA_PATH_CLA_BDA . 'Persistente.class.php' );

class MPUsuarioAcao extends Persistente {

function MPUsuarioAcao() {
	parent::Persistente();
	$this->setTabela( GBA_BD_TUSAC );
	$this->recuperaCamposTabela();	
}

}
?>