<?
/**
 	* Sistema imobCIEL
    * @license : GNU Lesser General Public License v.3
    * @link http://cielnews.com/imobciel
    * 
    * Formulario de Cadastro de Funcionalidade
    * Data de Criacao: 12/10/2008
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
$obDesktop = new IDiv('areaTrabalho');
$divAreaGeral->addComponente($obDesktop);
$obHtml->obHead->addJSArquivo('JSAcao.js');
$obHtml->obHead->addJSArquivo('JSFuncionalidade.js');

// Formulario

$obForm = new IFormulario();
$obForm->setAction('PRFuncionalidade.php');
$obForm->ativaTabela();

$obDesktop->addComponente($obForm);

// Codigo da Acao

$inCodFunc = (isset($_POST['codfuncionalidade'])) ? strip_tags($_POST['codfuncionalidade']) : '';

$obCodFunc = new IInput();
$obCodFunc->setType('hidden');
$obCodFunc->setNomeId('codfuncionalidade');
$obCodFunc->setValue($inCodFunc);

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

$obForm->addComponenteTabela('Módulo', $obModulo);

// Descricao da Funcionalidade

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