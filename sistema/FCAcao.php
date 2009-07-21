<?
/**
 	* Sistema imobCIEL
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/imobciel
    * 
    * Formulario de Cadastro de Acao
    * Data de Criacao: 29/09/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package imobCIEL
    * @subpackage
    *     
    * $Id$
    *     
    * Casos de uso: 
*/

include_once ('../gabphp/env/env.php');

Sessao::controle();

$obHtml = new IHtml;

$divAreaGeral = new IDiv('areaGeral');
$obHtml->obBody->addComponente($divAreaGeral);

include_once(GBA_PATH_INC . 'menu.php');

$obDesktop = new IDiv('areaTrabalho');
$obDesktop->setCss('areaTrab');
$divAreaGeral->addComponente($obDesktop);

// Carregar Javascript especifico
$obHtml->obHead->addJSArquivo('JSAcao.js');


// Formulario

$obForm = new IFormulario();
$obForm->setAction('PRAcao.php');
$obForm->ativaTabela();

$obDesktop->addComponente($obForm);

// Campo Chave - Codigo da Acao

// Inicialização de variaveis
$inCodAcao = '';
$inCodModulo = 1;
$inCodFuncionalidade = '';
$stDescricao = '';
$stPrograma = '';
$stOrdem = '';

if (isset($_REQUEST['codigo']))
{
	$inCodAcao = strip_tags($_REQUEST['codigo']);
	$obMPAcao = new MPAcao();
	$obMPAcao->addValor('codacao', $inCodAcao);
	$recordSet = new RecordSet();
	$recordSet->setResultados($obMPAcao->recuperar());
	
	if ($recordSet->getLinhas() > 0)
	{
		$inCodModulo = $recordSet->getValor('codmodulo');
		$inCodFuncionalidade = $recordSet->getValor('codfuncionalidade');
		$stDescricao = $recordSet->getValor('descricao');
		$stPrograma = $recordSet->getValor('programa');
		$stOrdem = $recordSet->getValor('ordem');
		$inCodAcaoExc = $inCodAcao;
	}
}

// Campo hidden chave
$obCodAcao = new IInput();
$obCodAcao->setType('hidden');
$obCodAcao->setNomeId('codacao');
$obCodAcao->setValue($inCodAcao);

$obForm->addComponente($obCodAcao);

// Modulo

//$inCodModulo = (isset($_REQUEST['codmodulo'])) ? strip_tags($_REQUEST['codmodulo']) : 1;

$obModulo = new ISelect();
$obModulo->setNomeId('codmodulo');
$obModulo->setMultiple(false);
$obModulo->setSelecionado(array($inCodModulo));

$obMPModulo = new MPModulo;
$obRsModulo = new RecordSet();
$obRsModulo->setResultados($obMPModulo->recuperar());

while ($arMod = $obRsModulo->getRegistro())
{
    $obModulo->addOpcao($arMod['codmodulo'], $arMod['descricao']);
}

$obModulo->obEvento->setOnChange("CarregaFuncionalidadesModulo(this.value)");
$obForm->addComponenteTabela('Módulo', $obModulo);

// Funcionalidade

//$inCodFuncionalidade = (isset($_REQUEST['codfuncionalidade'])) ? strip_tags($_REQUEST['codfuncionalidade']) : 1;

$obSpanFunc = new ISpan();
$obSpanFunc->setNomeId('funcionalidade');

$obFuncionalidade = new ISelect();
$obFuncionalidade->setNomeId('codfuncionalidade');
$obFuncionalidade->setMultiple(false);
$obFuncionalidade->setSelecionado($inCodFuncionalidade);

$obMPFuncionalidade = new MPFuncionalidade;
$obRsFuncionalidade = new RecordSet();
$obRsFuncionalidade->setResultados($obMPFuncionalidade->executaListaFuncionalidadePorModulo($inCodModulo));

while ($arFunc = $obRsFuncionalidade->getRegistro())
{
    $obFuncionalidade->addOpcao($arFunc['codfuncionalidade'], $arFunc['descricao']);
}

$obSpanFunc->addComponente($obFuncionalidade);
$obForm->addComponenteTabela('Funcionalidade', $obSpanFunc);

// Descricao da Ação

//$stDescricao = (isset($_POST['descricao'])) ? strip_tags($_POST['descricao']) : '';
$obDescricaoAcao = new IInput('descricao', $stDescricao, '', 40);
$obForm->addComponenteTabela('Descrição', $obDescricaoAcao);

// Programa

//$stPrograma = (isset($_POST['programa'])) ? strip_tags($_POST['programa']) : '';
$obPrograma = new IInput('programa', $stPrograma, '', 40);
$obForm->addComponenteTabela('Programa', $obPrograma);

// Ordem

//$stOrdem = (isset($_POST['ordem'])) ? strip_tags($_POST['ordem']) : '1';

$obOrdem = new ISelect;
$obOrdem->setNomeId('ordem');
$obOrdem->setSelecionado($stOrdem);
$arOpcoes = array('1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', '6'=>'6');
$obOrdem->setOpcao($arOpcoes);

$obForm->addComponenteTabela('Ordem', $obOrdem);

// Confirmar / Cancelar

$obConfirmarCancelar = new IConfirmarCancelar();
$obForm->addComponenteTabela('', $obConfirmarCancelar);

if (isset($inCodAcaoExc))
{
	$stNomeBotao = 'excluir_acao';
	$prExc = 'PRAcao.php?' . GBA_PREFIXO_VAR_EXCLUSAO . 'codacao=' . $inCodAcao;
	$obBotaoExcluir = new IInput($stNomeBotao, 'Excluir');
	$obBotaoExcluir->setType('button');
	$obBotaoExcluir->obEvento->setOnClick("document.location='" . $prExc . "'");
	$obForm->addComponenteTabela('', $obBotaoExcluir);
}

//Sistema::phpDebug($_SESSION["msg"], true);

// Renderiza o HTML
$obHtml->renderizar();
?>