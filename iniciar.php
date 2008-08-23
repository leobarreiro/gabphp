<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * P�gina Inicial Padr�o
    * Data de Cria��o: 21/06/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: iniciar.php 46 2008-06-25 04:13:41Z leobba $
    *     
    * Casos de uso : 
*/

include_once('Framework/Env/env.php');
include_once ( GBA_PATH_ENV . 'LoadDefs.php');
include_once(GBA_PATH_CLA_CMP . "LoadClasses.php");

Sessao::controle();

$obHtml = new IHtml;
$obHtml->obHead->setUrlCssFile(GBA_URL_SISTEMA . "Framework/Css/getpost.css");

include ('Framework/Includes/menu.php');

$obHtml->show();
?>
