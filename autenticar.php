<?php
/**
 	* Framework GABPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gab
    * 
    * Página de Autenticação Inicial no Sistema
    * Data de Criação: 25/01/2007
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: autenticar.php 46 2008-06-25 04:13:41Z leobba $
    *
*/

include_once('./gabphp/env/env.php');

if ( isset($_POST['usuario']) && strlen($_POST['senha']) 
	&& isset($_POST['senha']) && strlen($_POST['senha']) )
{
	$boSessao = Sessao::abre( strip_tags($_POST['usuario']), strip_tags($_POST['senha']) );
	header("Location: " . GBA_URL_SISTEMA . "iniciar.php");
}
else
{
	header("Location: " . GBA_URL_SISTEMA . "login.php");
}
?>