<?php
/**
 	* Framework GabPhp
    * @license : GNU Lesser General Public License v.3
    * @link http://cielnews.com/gab
    * 
    * Formulario para Cadastro de Módulo
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

require_once ('../gabphp/env/env.php');
require_once (GBA_PATH_CLA_MAP . 'MPModulo.class.php');

Sessao::controle();

$obHtml = new IHtml;

$divAreaGeral = new IDiv('areaGeral');
$obHtml->obBody->addComponente($divAreaGeral);

include_once(GBA_PATH_INC . 'menu.php');

$obDesktop = new IDiv('areaTrabalho');
$obDesktop->setCss('areaTrab');
$divAreaGeral->addComponente($obDesktop);

$obHtml->obHead->addJSArquivo('JSAcao.js');
$obHtml->obHead->addJSArquivo('JSFuncionalidade.js');

// Formulario

$obForm = new IFormulario();
$obForm->setAction('PRModulo.php');
$obForm->ativaTabela();
$obDesktop->addComponente($obForm);

// Codigo do Modulo - campo chave

$inCodModulo = '';
$stDescricao = '';
$stDiretorio = '';

if (isset($_REQUEST['codigo']))
{
	$inCodModulo = strip_tags($_REQUEST['codigo']);
	$obMap = new MPModulo();
	$obMap->addValor('codmodulo', $inCodModulo);
	$recordSet = new RecordSet();
	$recordSet->setResultados($obMap->recuperar());
	
	if ($recordSet->getLinhas() > 0)
	{
		$inCodModulo = $recordSet->getValor('codmodulo');
		$stDescricao = $recordSet->getValor('descricao');
		$stDiretorio = $recordSet->getValor('diretorio');
		$inCodModuloExc = $inCodModulo;
	}
}

$inpCodModulo = new IInput();
$inpCodModulo->setType('hidden');
$inpCodModulo->setNomeId('codmodulo');
$inpCodModulo->setValue($inCodModulo);

$obForm->addComponente($inpCodModulo);

// Descricao do Modulo

$obDescricaoModulo = new IInput();
$obDescricaoModulo->setNomeId('descricao');
$obDescricaoModulo->setValue($stDescricao);
$obForm->addComponenteTabela('Descrição', $obDescricaoModulo);

// Diretorio

$inpDiretorio = new IInput();
$inpDiretorio->setNomeId('diretorio');
$inpDiretorio->setValue($stDiretorio);
$obForm->addComponenteTabela('Diretorio', $inpDiretorio);

// Confirmar / Cancelar

$obConfirmarCancelar = new IConfirmarCancelar();
$obForm->addComponenteTabela('', $obConfirmarCancelar);


// Botao de Exclusao
if (isset($inCodModuloExc))
{
	$stNomeBotao = 'excluir_modulo';
	$prExc = 'PRModulo.php?' . GBA_PREFIXO_VAR_EXCLUSAO . 'codmodulo=' . $inCodModulo;
	$obBotaoExcluir = new IInput($stNomeBotao, 'Excluir');
	$obBotaoExcluir->setType('button');
	$obBotaoExcluir->obEvento->setOnClick("document.location='" . $prExc . "'");
	$obForm->addComponenteTabela('', $obBotaoExcluir);
}

// Renderiza o HTML
$obHtml->renderizar();
?>