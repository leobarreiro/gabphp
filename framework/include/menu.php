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

if (!isset($_COOKIE[GBA_COOKIE_NAME])) { header('Location: ../index.php'); }

$pag = substr($_SERVER['REQUEST_URI'], (strrpos($_SERVER['REQUEST_URI'], '/')+1));
if ($pag == 'menu.php') {
	header('Location: index.php');
}
	
/* ***********************************************
* Classes
* ********************************************** */
include_once (GBA_PATH_CLA_CMP . 'LoadClasses.php');
require_once (GBA_PATH_CLA_MAP . 'MPModulo.class.php');
require_once (GBA_PATH_CLA_MAP . 'MPFuncionalidade.class.php');
require_once (GBA_PATH_CLA_MAP . 'MPAcao.class.php');

if (isset($obHtml)) {
	
	$obImgLogo = new IImg(GBA_URL_SISTEMA . 'framework/images/logo.png', 'Financiel');
	$obImgLogo->setId('logo');
	$obHtml->obBody->addComponente($obImgLogo);
	
	$obScript = new IScript;
	$obScript->setLanguage('Javscript');
	$obScript->setType('text/javascript');
	$obScript->addFuncao("
	function ShowMn(elem) {
		var OptMn = new Array();
		OptMn[0] = 'MnCliente';
		OptMn[1] = 'MnCobranca';
		OptMn[2] = 'MnServico';
		var e = 0;
		for (e=0; e<OptMn.length; e++) {
			try {
				document.getElementById(OptMn[e]).style.display='none';
				document.getElementById(OptMn[e]).style.visibility='hidden';
			} catch(e) {}
		}
		try {
			document.getElementById(elem).style.display='inline';
			document.getElementById(elem).style.visibility='visible';
		} catch(e) {}
	}");
		
	$obHtml->obHead->addComponente($obScript);
	
	$obDivEtqSup = new IDiv('etqSup');
	if (isset($_SESSION) && isset($_SESSION['sessao']) && isset($_SESSION['sessao']['nomecompleto'])) {
		$obTextoUsuario = new ITexto('Usurio autenticado: ' . $_SESSION['sessao']['nomecompleto'] . '&nbsp;');
		$obDivEtqSup->addComponente($obTextoUsuario);
		$stUrlSair = (string) GBA_URL_SISTEMA . 'sair.php';
		$obLinkSair = new ILink('(sair)', $stUrlSair);
		$obDivEtqSup->addComponente($obLinkSair);
		$obTxtQuebra = new ITexto('<br>');
		$obDivEtqSup->addComponente($obTxtQuebra);
	}
	$obSpanDataServ = new ISpan('horaDataServ');
	$obSpanDataServ->setTitle('Data e Hora do Servidor');
	$obTextoDataServ = new ITexto(Sistema::dataServ());
	$obSpanDataServ->addComponente($obTextoDataServ);
	$obDivEtqSup->addComponente($obSpanDataServ);
	
	$obHtml->obBody->addComponente($obDivEtqSup);
	
	// Menu Superior
	$obDivMenuSup = new IDiv('menuSup');
	
	
	// Recuperar os Modulos Disponiveis do Sistema
	$obMPModulo = new MPModulo;
	$rsModulo = new RecordSet();
	$rsModulo->setResultados($obMPModulo->executaLista());
	
	if (isset($_SESSION) && isset($_SESSION['historico']) && is_array($_SESSION['historico']) && count($_SESSION['historico']) > 0) {
		$stPathModuloAtual = $_SESSION['historico'][(count($_SESSION['historico'])-1)];
		$stPathModuloAtual = substr($stPathModuloAtual, 0, strrpos($stPathModuloAtual, '/'));
	} else {
		$stPathModuloAtual = '';
	}
	
	while ($arModulo = $rsModulo->getRegistro()) {
		$stHrefModulo = (string) GBA_URL_SISTEMA . $arModulo['diretorio'];
		
		if ($stPathModuloAtual == $arModulo['diretorio']) {
			// Define o codigo do modulo
			$inCodModulo = $arModulo['codmodulo'];
			$obTxtModulo = new ITexto($arModulo['descricao']);
			$obTxtModulo->setBold(true);
			$obDivMenuSup->addComponente($obTxtModulo);
		} else {
			$obDivMenuSup->addComponente(new ILink($arModulo['descricao'], $stHrefModulo));			
		}
		$obDivMenuSup->addComponente(new ITexto('&nbsp;'));
	}
	
	$obDivMenuSup->addComponente(new ILink('Sair', GBA_URL_SISTEMA . 'sair.php'));
	
	// Adiciona ao HTML o Menu Superior com os Modulos do Sistema
	$obHtml->obBody->addComponente($obDivMenuSup);
	
	if (isset($inCodModulo) && $inCodModulo > 0) {
		
		$obMPFuncionalidade = new MPFuncionalidade;
		$rsFuncionalidade = new RecordSet();
		$rsFuncionalidade->setResultados($obMPFuncionalidade->executaListaFuncionalidadePorModulo($inCodModulo));
		
		if ($rsFuncionalidade->getLinhas() > 0) {
			
			//Funcionalidade do Mdulo
			$obDivMenuLateral = new IDiv();
			$obDivMenuLateral->setCss('mnLateral');			
			while($arFuncionalidade = $rsFuncionalidade->getRegistro()) {
				$obDivFuncionalidade = new IDiv();
				$obDivFuncionalidade->addComponente(new ITexto($arFuncionalidade['descricao']));
				$obDivMenuLateral->addComponente($obDivFuncionalidade);
				//Aes da Funcionalidade
				$obMPAcao = new MPAcao;
				$rsAcao = new RecordSet();
				$rsAcao->setResultados($obMPAcao->executaListaAcaoPorFuncionalidade($arFuncionalidade['codfuncionalidade']));
				
				if ($rsAcao->getLinhas() > 0) {
					
					$obMenuFuncionalidade = new ILista();
					$obMenuFuncionalidade->setTag('ul');
					
					while($arAcao = $rsAcao->getRegistro()) {
						
						$stUrlAcao = '';
						if (strlen($arFuncionalidade['diretorio'])) {
							$stUrlAcao .= $arFuncionalidade['diretorio'] . '/';
						}
						$stUrlAcao .= $arAcao['programa'];
						
						$obLinkAcao = new ILink($arAcao['descricao'], $stUrlAcao);
						$obMenuFuncionalidade->addComponente($obLinkAcao);
					}
					
					$obDivMenuLateral->addComponente($obMenuFuncionalidade);
					
				}
				
			}
			
			$obHtml->obBody->addComponente($obDivMenuLateral);
					
		}
		
	}

}
?>