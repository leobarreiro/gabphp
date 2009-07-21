<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
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
$obForm->setAction('PRModulo.php');
$obForm->ativaTabela();
$obDesktop->addComponente($obForm);

// Codigo do Modulo

$inCodModulo = (isset($_POST['codmodulo'])) ? strip_tags($_POST['codmodulo']) : '';

$inpCodModulo = new IInput();
$inpCodModulo->setType('hidden');
$inpCodModulo->setNomeId('codmodulo');
$inpCodModulo->setValue($inCodModulo);

$obForm->addComponente($inpCodModulo);

// Descricao do Modulo

$stDescricao = (isset($_POST['descricao'])) ? strip_tags($_POST['descricao']) : '';
$obDescricaoModulo = new IInput();
$obDescricaoModulo->setNomeId('descricao');
$obDescricaoModulo->setValue($stDescricao);
$obForm->addComponenteTabela('Descrição', $obDescricaoModulo);

// Diretorio

$stDiretorio = (isset($_POST['diretorio'])) ? strip_tags($_POST['diretorio']) : '';
$inpDiretorio = new IInput();
$inpDiretorio->setNomeId('diretorio');
$inpDiretorio->setValue($stDiretorio);
$obForm->addComponenteTabela('Diretorio', $inpDiretorio);

// Confirmar / Cancelar

$obConfirmarCancelar = new IConfirmarCancelar();
$obForm->addComponenteTabela('', $obConfirmarCancelar);

// Renderiza o HTML
$obHtml->renderizar();
?>