<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Página de Redirecionamento Padrão
    * Data de Criação: 21/06/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: $
    *     
    * Casos de uso : 
*/

include_once('./gabphp/env/env.php');

if (isset($_COOKIE[GBA_COOKIE_NAME]))
{
	header("Cache-control: private");
	header ("Location: " . GBA_URL_SISTEMA . "iniciar.php");
}
else
{
	header("Cache-control: private");
	header ("Location: " . GBA_URL_SISTEMA . "login.php");
}
?>