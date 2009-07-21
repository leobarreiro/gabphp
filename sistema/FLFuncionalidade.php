<?
/**
 	* Framework GabPhp
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gab
    * 
    * Lista de Funcionalidades
    * Data de Criacao: 12/07/2009
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


// Definicao do RecordSet na Sessao
// Inicializa o RecordSet

Sessao::gravarRecordSet('funcionalidade', new RecordSet());

// Formulario de Pesquisa

$obForm = new IFormulario;
$obDesktop->addComponente($obForm);

$obForm->setAction('LSFuncionalidade.php');
$obForm->ativaTabela();

// Módulo

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

// Descricao

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