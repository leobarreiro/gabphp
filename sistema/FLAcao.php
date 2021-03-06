<?
/**
 	* Sistema imobCIEL
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/imobciel
    * 
    * Lista de Acoes
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

// Definicao do RecordSet na Sessao
// Inicializa o RecordSet

Sessao::gravarRecordSet('acao', new RecordSet());

// Formulario de Pesquisa

$obForm = new IFormulario;
$obDesktop->addComponente($obForm);

$obForm->setAction('LSAcao.php');
$obForm->ativaTabela();

// Modulo

$inCodModulo = '';

$obModulo = new ISelect();
$obModulo->setNomeId('codmodulo');
$obModulo->setMultiple(false);
$obModulo->setSelecionado($inCodModulo);
$obModulo->addOpcao('', 'Selecione');

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

$inCodFuncionalidade = '';

$obSpanFunc = new ISpan();
$obSpanFunc->setNomeId('funcionalidade');

$obFuncionalidade = new ISelect();
$obFuncionalidade->setNomeId('codfuncionalidade');
$obFuncionalidade->setMultiple(false);
$obFuncionalidade->setSelecionado($inCodFuncionalidade);
$obFuncionalidade->addOpcao('', 'Selecione');

$obMPFuncionalidade = new MPFuncionalidade;
$obRsFuncionalidade = new RecordSet();
$obRsFuncionalidade->setResultados($obMPFuncionalidade->executaListaFuncionalidadePorModulo($inCodModulo));

while ($arFunc = $obRsFuncionalidade->getRegistro())
{
    $obFuncionalidade->addOpcao($arFunc['codfuncionalidade'], $arFunc['descricao']);
}

$obSpanFunc->addComponente($obFuncionalidade);
$obForm->addComponenteTabela('Funcionalidade', $obSpanFunc);

// Descricao da Açao

$obInputDescricao = new IInput;
$obInputDescricao->setNomeId('descricao');
$obInputDescricao->setSize(40);
$obInputDescricao->setMaxLength(40);
$obForm->addComponenteTabela('Descrição', $obInputDescricao);

// Confirmar / Cancelar

$obInputConfCanc = new IConfirmarCancelar();
$obForm->addComponenteTabela(null, $obInputConfCanc);

// Renderiza o HTML

$obHtml->renderizar();
?>