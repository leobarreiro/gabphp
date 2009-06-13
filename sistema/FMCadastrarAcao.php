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
    * $Id: $
    *     
    * Casos de uso: 
*/


include_once('../framework/env/env.php');
include_once ( GBA_PATH_ENV . 'LoadDefs.php');
include_once(GBA_PATH_CLA_CMP . "LoadClasses.php");

Sessao::controle();

$obHtml = new IHtml;

$obHtml->obHead->addCSSArquivo(GBA_URL_SISTEMA . "framework/css/gbaphp.css");
$obHtml->obHead->addJSArquivo('../../gba/framework/js/gba_ajax.js');
$obHtml->obHead->addJSArquivo('JSAcao.js');

include (GBA_PATH_FWK . 'include/menu.php');

// Area de Trabalho

$obDesktop = new IDiv('areaTrabalho');
$obHtml->obBody->addComponente($obDesktop);

// Formulario

$obForm = new IFormulario();
$obForm->setAction('PRCadastrarAcao.php');
$obForm->ativaTabela();

$obDesktop->addComponente($obForm);

// Codigo da Acao

$inCodAcao = (isset($_POST['codacao'])) ? strip_tags($_POST['codacao']) : '';

$obCodAcao = new IInput();
$obCodAcao->setType('hidden');
$obCodAcao->setNomeId('codacao');
$obCodAcao->setValue($inCodAcao);

// Modulo

$inCodModulo = (isset($_POST['codmodulo'])) ? strip_tags($_POST['codmodulo']) : 1;

$obModulo = new ISelect();
$obModulo->setNomeId('codmodulo');
$obModulo->setMultiple(false);
$obModulo->setSelecionado(array($inCodModulo));

$obMPModulo = new MPModulo;
$obRsModulo = new RecordSet();
$obRsModulo->setResultados($obMPModulo->recuperar());

while ($arMod = $obRsModulo->getRegistro()) {
    $obModulo->addOpcao($arMod['codmodulo'], $arMod['descricao']);
}

$obModulo->obEvento->setOnChange("CarregaFuncionalidadesModulo(this.value)");
$obForm->addComponenteTabela('Módulo', $obModulo);

// Funcionalidade

$inCodFuncionalidade = (isset($_POST['codfuncionalidade'])) ? strip_tags($_POST['codfuncionalidade']) : 1;

$obSpanFunc = new ISpan();
$obSpanFunc->setNomeId('funcionalidade');

$obFuncionalidade = new ISelect();
$obFuncionalidade->setNomeId('codfuncionalidade');
$obFuncionalidade->setMultiple(false);
$obFuncionalidade->setSelecionado($inCodFuncionalidade);

$obMPFuncionalidade = new MPFuncionalidade;
$obRsFuncionalidade = new RecordSet();
$obRsFuncionalidade->setResultados($obMPFuncionalidade->recuperar());

while ($arFunc = $obRsFuncionalidade->getRegistro()) {
    $obFuncionalidade->addOpcao($arFunc['codfuncionalidade'], $arFunc['descricao']);
}

$obSpanFunc->addComponente($obFuncionalidade);
$obForm->addComponenteTabela('Funcionalidade', $obSpanFunc);

// Descricao da Ação

$stDescricao = (isset($_POST['descricao'])) ? strip_tags($_POST['descricao']) : '';

$obDescricaoAcao = new IInput();
$obDescricaoAcao->setNomeId('descricao');
$obDescricaoAcao->setValue($stDescricao);

$obForm->addComponenteTabela('Descrição', $obDescricaoAcao);

// Programa

$stPrograma = (isset($_POST['programa'])) ? strip_tags($_POST['programa']) : '';

$obPrograma = new IInput();
$obPrograma->setNomeId('programa');
$obPrograma->setValue($stPrograma);

$obForm->addComponenteTabela('Programa', $obPrograma);

// Ordem

$stOrdem = (isset($_POST['ordem'])) ? strip_tags($_POST['ordem']) : '1';

$obOrdem = new ISelect;
$obOrdem->setNomeId('ordem');
$obOrdem->setSelecionado($stOrdem);
$arOpcoes = array('1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', '5'=>'5', '6'=>'6');
$obOrdem->setOpcao($arOpcoes);

$obForm->addComponenteTabela('Ordem', $obOrdem);

// Confirmar / Cancelar

$obConfirmarCancelar = new IConfirmarCancelar();

$obForm->addComponenteTabela('', $obConfirmarCancelar);

// Renderiza o HTML

$obHtml->renderizar();
?>