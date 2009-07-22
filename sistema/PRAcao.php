<?
/**
 	* Framework GabPhp
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gab
    * 
    * Processamento de Cadastro de Acao
    * Data de Criacao: 29/09/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package GabPhp
    * @subpackage sistema
    *     
    * $Id$
    *     
    * Casos de uso: 
*/

include_once('../gabphp/env/env.php');
require_once(GBA_PATH_CLA_MAP . 'MPAcao.class.php');

Sessao::controle();

// Instancia Objeto de Mapeamento

$obMap = new MPAcao;

// Campo Chave para Determinar a Operacao
// Inclusao ou Atualizacao

$stCampoChave = 'codacao';
$stCampoChaveExclusao = GBA_PREFIXO_VAR_EXCLUSAO . 'codacao';


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


// Controle de Sequencia de Operacao

$boProssegue = true;

// Controle de Retorno de Mensagem

$arErro = array();

// Campos Obrigatorios para Cadastro

$arCampos = array('codmodulo', 'codfuncionalidade', 'descricao', 'programa', 'ordem');
$arDescr  = array('Módulo', 'Funcionalidade', 'Descrição', 'Programa', 'Ordem');

for ($x=0; $x<count($arCampos); $x++)
{
    if (!isset($_REQUEST[$arCampos[$x]]))
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
    header('Location: FCAcao.php');
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
}

header('Location: FCAcao.php');

?>