<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Pсgina de Autenticaчуo Inicial no Sistema
    * Data de Criaчуo: 25/01/2007
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: autenticar.php 46 2008-06-25 04:13:41Z leobba $
    *     
    * Casos de uso : 
*/

include_once ( 'Framework/Env/env.php' );
include_once ( 'Framework/Env/LoadDefs.php' );

if ( isset($_POST['usuario']) && strlen($_POST['senha']) 
	&& isset($_POST['senha']) && strlen($_POST['senha']) ) {
	$boSessao = Sessao::abre( strip_tags($_POST['usuario']), strip_tags($_POST['senha']) );
	header("Location: " . GBA_URL_SISTEMA . "iniciar.php");
} else {
	header("Location: " . GBA_URL_SISTEMA . "login.php");
}
?>