<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Menu Base para o Sistema
    * Data de Criao: 24/06/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: menu.php 56 2008-07-05 06:31:00Z leobba $
    *     
    * Casos de uso : 
*/

if (!isset($_COOKIE[GBA_COOKIE_NAME]))
{
	header('Location: ../index.php');
}

$pag = substr($_SERVER['REQUEST_URI'], (strrpos($_SERVER['REQUEST_URI'], '/')+1));

if ($pag == 'menu.php')
{
	header('Location: index.php');
}
	
/* ***********************************************
* Classes
* ********************************************** */
include_once (GBA_PATH_CLA_CMP . 'LoadClasses.php');
require_once (GBA_PATH_CLA_MAP . 'MPModulo.class.php');
require_once (GBA_PATH_CLA_MAP . 'MPFuncionalidade.class.php');
require_once (GBA_PATH_CLA_MAP . 'MPAcao.class.php');

$iDivAreaSuperior = new IDiv('areaSuperior');
$iDivAreaSuperior->setCss('areaSuperior');

$divAreaGeral->addComponente($iDivAreaSuperior);

$obImgLogo = new IDiv('logoGba');
$iDivAreaSuperior->addComponente($obImgLogo);

$obHtml->obHead->setCharset('UTF-8');
$obHtml->obHead->addCSSArquivo(GBA_URL_SISTEMA . "gabphp/css/gabphp.css");
$obHtml->obHead->addJSArquivo('../gabphp/js/gabajax.js');
$obHtml->obHead->addJSArquivo('../gabphp/js/gabphp.js');
$obHtml->obHead->addJSArquivo('../gabphp/js/funcoes.js');

$obDivEtqSup = new IDiv('etqSup');
$iDivAreaSuperior->addComponente($obDivEtqSup);

if (isset($_SESSION) && isset($_SESSION['sessao']) && isset($_SESSION['sessao']['nomecompleto']))
{
	$obTextoUsuario = new ISpan();
	$obTextoUsuario->addComponente(new ITexto('Usuário autenticado: ' . $_SESSION['sessao']['nomecompleto'] . '&nbsp;'));
	$stUrlSair = (string) GBA_URL_SISTEMA . 'sair.php';
	$obTextoUsuario->addComponente(new ILink('(sair)', $stUrlSair));
	$obDivEtqSup->addComponente($obTextoUsuario);
}
$obSpanDataServ = new ISpan('horaDataServ');
$obSpanDataServ->setTitle('Data e Hora do Servidor');
$obTextoDataServ = new ITexto(Sistema::dataServ());
$obSpanDataServ->addComponente($obTextoDataServ);
$obDivEtqSup->addComponente($obSpanDataServ);

// Menu Superior

$obDivMenuSup = new IDiv('menuSup');
$iDivAreaSuperior->addComponente($obDivMenuSup);

// Titulo de Pagina

$obDivTituloPagina = new IDiv('tituloPagina');
$obDivTituloPagina->setCss('titPag');

// Recuperar os Modulos Disponiveis do Sistema

$obMPModulo = new MPModulo;
$rsModulo = new RecordSet();
$rsModulo->setResultados($obMPModulo->executaLista());

if (isset($_SESSION) && isset($_SESSION['historico']) && is_array($_SESSION['historico']) && count($_SESSION['historico']) > 0)
{
	$stPathModuloAtual = $_SESSION['historico'][(count($_SESSION['historico'])-1)];
	$stPathModuloAtual = substr($stPathModuloAtual, 0, strrpos($stPathModuloAtual, '/'));
}
else
{
	$stPathModuloAtual = '';
}

while ($arModulo = $rsModulo->getRegistro())
{
	$stHrefModulo = (string) GBA_URL_SISTEMA . $arModulo['diretorio'];	
	$obItemMenuSup = new IDiv();
	
	if ($stPathModuloAtual == $arModulo['diretorio'])
	{
		// Define o codigo do modulo
		$inCodModulo = $arModulo['codmodulo'];
		$obTxtModulo = new ITexto($arModulo['descricao']);
		$obTxtModulo->setBold(true);
		$obItemMenuSup->setCss('ativo');
		$obItemMenuSup->addComponente($obTxtModulo);
	}
	else
	{
		$obLinkItemMenuSup = new ILink($arModulo['descricao'], $stHrefModulo);
		$obItemMenuSup->setCss('inativo');
		$obItemMenuSup->addComponente($obLinkItemMenuSup);
	}
	$obDivMenuSup->addComponente($obItemMenuSup);
	//$obDivMenuSup->addComponente(new ITexto('&nbsp;'));
}

if (isset($inCodModulo) && $inCodModulo > 0)
{
	$obMPFuncionalidade = new MPFuncionalidade;
	$rsFuncionalidade = new RecordSet();
	$rsFuncionalidade->setResultados($obMPFuncionalidade->executaListaFuncionalidadePorModulo($inCodModulo));
	
	if ($rsFuncionalidade->getLinhas() > 0)
	{
		$stProgramaAtual = substr($_SERVER['SCRIPT_FILENAME'], (strrpos($_SERVER['SCRIPT_FILENAME'], '/')+1));
		//Funcionalidade do Mdulo
		$obDivMenuLateral = new IDiv('mnLateral');
		$divAreaGeral->addComponente($obDivMenuLateral);
		$obDivMenuLateral->setCss('mnLateral');
		$obDivMenuLateral->obEvento->setOnDblClick('AlternaMenu(this)');
		while ($arFuncionalidade = $rsFuncionalidade->getRegistro())
		{
			$obDivFuncionalidade = new IDiv();
			$obDivFuncionalidade->addComponente(new ITexto($arFuncionalidade['descricao']));
			$obDivMenuLateral->addComponente($obDivFuncionalidade);
			//Aes da Funcionalidade
			$obMPAcao = new MPAcao;
			$rsAcao = new RecordSet();
			$rsAcao->setResultados($obMPAcao->executaListaAcaoPorFuncionalidade($arFuncionalidade['codfuncionalidade']));
			if ($rsAcao->getLinhas() > 0)
			{	
				$obMenuFuncionalidade = new ILista();
				$obMenuFuncionalidade->setTag('ul');
				while ($arAcao = $rsAcao->getRegistro())
				{	
					if ($stProgramaAtual == $arAcao['programa'])
					{
						// Cria um Texto em negrito para adicionar ao Menu
						$obTextoAcao = new ITexto($arAcao['descricao']);
						$obTextoAcao->setBold(true);
						$obMenuFuncionalidade->addComponente($obTextoAcao);
						// Grava na Sessao o Titulo de Pagina
						Sessao::gravarTituloPagina($arAcao['descricao']);
					}
					else
					{	
						// Monta o Link no Menu Lateral
						$stUrlAcao = '';
						if (strlen($arFuncionalidade['diretorio']))
						{
							$stUrlAcao .= $arFuncionalidade['diretorio'] . '/';
						}
						$stUrlAcao .= $arAcao['programa'];
						$obLinkAcao = new ILink($arAcao['descricao'], $stUrlAcao);
						$obMenuFuncionalidade->addComponente($obLinkAcao);
					}
				}
				$obDivMenuLateral->addComponente($obMenuFuncionalidade);
			}
		}
	}
	
	$obDivTituloPagina->addComponente(new ITexto(Sessao::recuperarUltimoTituloPagina()));
}

$divAreaGeral->addComponente($obDivTituloPagina);
?>