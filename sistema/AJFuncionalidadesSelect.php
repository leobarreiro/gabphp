<?php
/**
 	* Sistema imobCIEL
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/imobciel
    * 
    * Select de Funcionalidades chamada por Ajax
    * Data de Criacao: 11/10/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package imobCIEL
    * @subpackage
    *     
    * $Id: $
    *     
    * Casos de uso: 
*/


include_once('../framework/env/env.php');
include_once ( GBA_PATH_ENV . 'LoadDefs.php');
include_once(GBA_PATH_CLA_CMP . "LoadClasses.php");
require_once(GBA_PATH_CLA_MAP . 'MPFuncionalidade.class.php');

Sessao::controle();

// Define charset encoding para retorno

header("Content-Type: text/html; charset=UTF-8",true);

// Tratamento de Parâmetros

$inCodModulo = (isset($_GET['codmodulo'])) ? strip_tags($_GET['codmodulo']) : 5;


// Montagem do HTML

// Funcionalidade

$obFuncionalidade = new ISelect();
$obFuncionalidade->setNomeId('codfuncionalidade');
$obFuncionalidade->setMultiple(false);

$obMPFuncionalidade = new MPFuncionalidade;
$obRsFuncionalidade = new RecordSet();
$obRsFuncionalidade->setResultados($obMPFuncionalidade->executaListaFuncionalidadePorModulo($inCodModulo));

while ($arFunc = $obRsFuncionalidade->getRegistro()) {
    $obFuncionalidade->addOpcao($arFunc['codfuncionalidade'], $arFunc['descricao']);
}

$obFuncionalidade->montaHtml();
echo $obFuncionalidade->stHtml;
?>