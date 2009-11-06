<?php
/**
 	* Framework GabPhp
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gab
    * 
    * Processamento de Cadastro de Acao
    * Data de Criacao: 06/08/2009
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
require_once(GBA_PATH_CLA_EST . 'Sistema.class.php');
require_once(GBA_PATH_CLA_MAP . 'MPUsuario.class.php');

Sessao::controle();

Sistema::phpDebug($_SESSION, true);

// Instancia Objeto de Mapeamento

$obMap = new MPUsuario;

// Codigo do Usuario

$inCodUsuario = $_SESSION['sessao']['codusuario'];

// Controle de Sequencia de Operacao

$boProssegue = true;

// Controle de Retorno de Mensagem

$arErro = array();

// Campos Obrigatorios para Cadastro

$arCampos = array('nomecompleto', 'email');
$arDescr  = array('Nome', 'E-mail');

for ($x=0; $x<count($arCampos); $x++)
{
    if (!isset($_REQUEST[$arCampos[$x]]))
    {
        $arErro[] = 'Campo ' . $arDescr[$x] . ' faltando.';
        $boProssegue = false;
    }
    else
    {
		if (strlen(strip_tags($_REQUEST[$arCampos[$x]])) > 0)
		{
			$obMap->addValor($arCampos[$x], strip_tags($_POST[$arCampos[$x]]));
		}
		else
		{
			$arErro[] = 'Campo ' . $arDescr[$x] . ' em branco.';
			$boProssegue = false;
		}
    }
}

// Nao ocorreu validacao para Continuar a Operacao

if (!$boProssegue)
{
    header('Location: FCDadosPessoais.php');
}

// Alteração de Dados Pessoais

$inOperacao = $obMap->alterarDadosPessoais();
if (!$obMap->getErro())
{
	Sessao::gravarMensagem('Dados Pessoais alterados corretamente!');
}

if ($obMap->getErro())
{
    Sessao::gravarMensagem($obMap->getMsgErro());
}

header('Location: FCDadosPessoais.php');
?>