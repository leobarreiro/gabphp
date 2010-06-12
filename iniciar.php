<?php
/**
 	* Framework GABPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gab
    * 
    * Página Inicial Padrão
    * Data de Criao: 21/06/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: iniciar.php 46 2008-06-25 04:13:41Z leobba $
    *     
    * Casos de uso : 
*/

include_once('./gabphp/env/env.php');
include_once(GBA_PATH_ENV . 'LoadDefs.php');
include_once(GBA_PATH_CLA_CMP . "LoadClasses.php");

Sessao::controle();

$obHtml = new IHtml;

$divAreaGeral = new IDiv('areaGeral');
$obHtml->obBody->addComponente($divAreaGeral);

include_once(GBA_PATH_INC . 'menu.php');

$obDesktop = new IDiv('areaTrabalho');
$divAreaGeral->addComponente($obDesktop);

$obHtml->renderizar();
?>