<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Pgina de Encerramento de Sesso
    * Data de Criao: 21/06/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: sair.php 46 2008-06-25 04:13:41Z leobba $
    *     
    * Casos de uso : 
*/

include ('framework/env/env.php');
include_once ( GBA_PATH_ENV . 'LoadDefs.php');
include_once(GBA_PATH_CLA_CMP . "LoadClasses.php");

if (isset($_COOKIE[GBA_COOKIE_NAME])) {
	$boRetorno = Sessao::fecha();
	$boDestroi = Cookie::destroi(GBA_COOKIE_NAME);
}

header("Cache-control: private");
header("Location: " . GBA_URL_SISTEMA . "index.php");
?>