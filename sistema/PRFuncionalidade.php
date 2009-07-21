<?
/**
 	* Sistema GabPhp
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/GAB
    * 
    * Processamento de Cadastro de Funcionalidade
    * Data de Criacao: 12/10/2008
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
require_once(GBA_PATH_CLA_MAP . 'MPFuncionalidade.class.php');

Sessao::controle();

// Instancia Objeto de Mapeamento

$obMap = new MPFuncionalidade;

// Campo Chave para Determinar a Operacao
// Inclusao ou Atualizacao

$stCampoChave = 'codfuncionalidade';
$stCampoChaveExclusao = GBA_PREFIXO_VAR_EXCLUSAO . 'codfuncionalidade';

if (isset($_REQUEST[$stCampoChave]) && strlen(strip_tags($_REQUEST[$stCampoChave])) > 0)
{
    $stAcao = 'alterar';
    $obMap->addValor($stCampoChave, strip_tags($_REQUEST[$stCampoChave]));
}
elseif (isset($_REQUEST[$stCampoChaveExclusao]) && strlen(strip_tags($_REQUEST[$stCampoChaveExclusao])) > 0)
{
	$stAcao = 'excluir';
	$obMap->addValor('codfuncionalidade', strip_tags($_REQUEST[$stCampoChaveExclusao]));
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
$arCampos = array('codmodulo', 'codfuncionalidade', 'descricao', 'programa');
$arDescr  = array('Módulo', 'Funcionalidade', 'Descrição', 'Programa');

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
    header('Location: FCFuncionalidade.php');
}

if ($stAcao == 'incluir')
{
    $inOperacao = $obMap->incluir();
    if (!$obMap->getErro())
    {
        Sessao::gravarMensagem('Funcionalidade Incluida corretamente!');
    }
}
elseif ($stAcao == 'alterar')
{
    $inOperacao = $obMap->alterar();
    if (!$obMap->getErro())
    {
        Sessao::gravarMensagem('Funcionalidade Alterada corretamente!');
    }
}
elseif ($stAcao == 'excluir')
{
	$inOperacao = $obMap->excluir();
	if (!$obMap->getErro())
	{
		Sessao::gravarMensagem('Funcionalidade Excluída corretamente!');
	}
}

if ($obMap->getErro())
{
    Sessao::gravarMensagem($obMap->getMsgErro());
}

header('Location: FCFuncionalidade.php');
?>