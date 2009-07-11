<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Processamento de Cadastro de Módulo
    * Data de Criacao: 27/06/2009
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id$
    *     
    * Casos de uso : 
*/


include_once('../env/env.php');
include_once ( GBA_PATH_ENV . "LoadDefs.php");
include_once(GBA_PATH_CLA_CMP . "LoadClasses.php");
require_once(GBA_PATH_CLA_MAP . 'MPModulo.class.php');

Sessao::controle();

// Instancia Objeto de Mapeamento

$obMap = new MPModulo;

// Campo Chave para Determinar a Operacao
// Inclusao ou Atualizacao

$stCampoChave = 'codmodulo';

if (isset($_POST[$stCampoChave]) && strlen(strip_tags()) > 0)
{
    $stAcao = 'alterar';
    $obMap->addValor($stCampoChave, strip_tags($_POST[$stCampoChave]));
}
else
{
    $stAcao = 'incluir';
}

// Controle de Sequencia de Operacao
$boProssegue = true;

// Controle de Retorno de Mensagem
$arErro = array();

// Campos Obrigatorios para Cadastro
$arCampos = array('descricao', 'diretorio');
$arDescr  = array('Descrição', 'Diretório');

for ($x=0; $x<count($arCampos); $x++)
{
    if (!isset($_POST[$arCampos[$x]]))
	{
        $arErro[] = 'Campo ' . $arDescr[$x] . ' faltando.';
        $boProssegue = false;
    }
	else
	{
        $obMap->addValor($arCampos[$x], strip_tags($_POST[$arCampos[$x]]));
    }
}

// Nao ocorreu validacao para Continuar a Operacao
if (!$boProssegue)
{
    header('Location: FCModulo.php');
}

if ($stAcao == 'incluir')
{
    $inOperacao = $obMap->incluir();
    if (!$obMap->getErro())
	{
        Sessao::gravarMensagem('Módulo Incluído corretamente!');
    }
}
else
{
	$inOperacao = $obMap->alterar();
    if (!$obMap->getErro())
	{
        Sessao::gravarMensagem('Módulo Alterado corretamente!');
    }
}

if ($obMap->getErro())
{
    Sessao::gravarMensagem($obMap->getMsgErro());
}

header('Location: FCModulo.php');
?>