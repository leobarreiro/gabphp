<?php
/**
 	* Framework GabPhp
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gab
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


require_once('../gabphp/env/env.php');
require_once(GBA_PATH_CLA_MAP . 'MPModulo.class.php');

Sessao::controle();

// Instancia Objeto de Mapeamento

$obMap = new MPModulo;

// Campo Chave para Determinar a Operacao
// Inclusao ou Atualizacao

$stCampoChave = 'codmodulo';
$stCampoChaveExclusao = GBA_PREFIXO_VAR_EXCLUSAO . 'codmodulo';

if (isset($_REQUEST[$stCampoChave]) && strlen(strip_tags($_REQUEST[$stCampoChave])) > 0)
{
    $stAcao = 'alterar';
    $obMap->addValor($stCampoChave, strip_tags($_REQUEST[$stCampoChave]));
}
elseif (isset($_REQUEST[$stCampoChaveExclusao]) && strlen(strip_tags($_REQUEST[$stCampoChaveExclusao])) > 0)
{
	$stAcao = 'excluir';
	$obMap->addValor($stCampoChave, strip_tags($_REQUEST[$stCampoChaveExclusao]));
}
else
{
    $stAcao = 'incluir';
}

//Sistema::phpDebug($stAcao, true);

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

//Sistema::phpDebug($obMap, true);

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
        Sessao::gravarMensagem('Ação Incluida corretamente!');
    }
}
elseif ($stAcao == 'alterar')
{
    $inOperacao = $obMap->alterar();
    if (!$obMap->getErro())
    {
        Sessao::gravarMensagem('Ação Alterada corretamente!');
    }
}
elseif ($stAcao == 'excluir')
{
	$inOperacao = $obMap->excluir();
	if (!$obMap->getErro())
	{
		Sessao::gravarMensagem('Ação Excluída corretamente!');
	}
}

if ($obMap->getErro())
{
    Sessao::gravarMensagem($obMap->getMsgErro());
	$obMap->logError();
}

header('Location: FCModulo.php');
?>