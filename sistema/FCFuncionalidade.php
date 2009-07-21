<?
/**
 	* Framework GabPhp
    * @license : GNU Lesser General Public License v.3
    * @link http://cielnews.com/gab
    * 
    * Formulario de Cadastro de Funcionalidade
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

include_once ('../gabphp/env/env.php');

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
$obForm->setAction('PRFuncionalidade.php');
$obForm->ativaTabela();

$obDesktop->addComponente($obForm);

// Codigo da Funcionalidade - campo chave

// Inicializaçao de valores
$inCodFunc = '';
$inCodModulo = 1;
$stDescricao = '';
$stPrograma = '';
$stDiretorio = '';
$inCodFuncExc = '';

if (isset($_REQUEST['codigo']))
{
	$inCodFunc = strip_tags($_REQUEST['codigo']);
	$obMPFunc = new MPFuncionalidade();
	$obMPFunc->addValor('codfuncionalidade', $inCodFunc);
	$recordSet = new RecordSet();
	$recordSet->setResultados($obMPFunc->recuperar());
	
	if ($recordSet->getLinhas() > 0)
	{
		$inCodModulo = $recordSet->getValor('codmodulo');
		$stDescricao = $recordSet->getValor('descricao');
		$stPrograma = $recordSet->getValor('programa');
		$stDiretorio = $recordSet->getValor('diretorio');
		$inCodFuncExc = $inCodFunc;
	}
}

$obCodFunc = new IInput();
$obCodFunc->setType('hidden');
$obCodFunc->setNomeId('codfuncionalidade');
$obCodFunc->setValue($inCodFunc);

// Modulo

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

$obForm->addComponenteTabela('Módulo', $obModulo);

// Descricao da Funcionalidade

$obDescricao = new IInput();
$obDescricao->setNomeId('descricao');
$obDescricao->setValue($stDescricao);
$obForm->addComponenteTabela('Descrição', $obDescricao);

// Programa

$obPrograma = new IInput();
$obPrograma->setNomeId('programa');
$obPrograma->setValue($stPrograma);
$obForm->addComponenteTabela('Programa', $obPrograma);

// Confirmar / Cancelar

$obConfirmarCancelar = new IConfirmarCancelar();
$obForm->addComponenteTabela('', $obConfirmarCancelar);

// Botao de Exclusao
if (isset($inCodFuncExc))
{
	$stNomeBotao = 'excluir_funcionalidade';
	$prExc = 'PRFuncionalidade.php?' . GBA_PREFIXO_VAR_EXCLUSAO . 'codfuncionalidade=' . $inCodFunc;
	$obBotaoExcluir = new IInput($stNomeBotao, 'Excluir');
	$obBotaoExcluir->setType('button');
	$obBotaoExcluir->obEvento->setOnClick("document.location='" . $prExc . "'");
	$obForm->addComponenteTabela('', $obBotaoExcluir);
}

// Renderiza o HTML

$obHtml->renderizar();

?>