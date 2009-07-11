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
$divAreaGeral->addComponente($obDesktop);


// Formulario

$obForm = new IFormulario();
$obForm->setAction('PRAcao.php');
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

while ($arMod = $obRsModulo->getRegistro())
{
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

while ($arFunc = $obRsFuncionalidade->getRegistro())
{
    $obFuncionalidade->addOpcao($arFunc['codfuncionalidade'], $arFunc['descricao']);
}

$obSpanFunc->addComponente($obFuncionalidade);
$obForm->addComponenteTabela('Funcionalidade', $obSpanFunc);

// Descricao da Ação

$stDescricao = (isset($_POST['descricao'])) ? strip_tags($_POST['descricao']) : '';
$obDescricaoAcao = new IInput('descricao', $stDescricao, '', 40);
$obForm->addComponenteTabela('Descrição', $obDescricaoAcao);

// Programa

$stPrograma = (isset($_POST['programa'])) ? strip_tags($_POST['programa']) : '';
$obPrograma = new IInput('programa', $stPrograma, '', 40);
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