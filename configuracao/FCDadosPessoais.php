<?php
/**
 	* Sistema imobCIEL
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/imobciel
    * 
    * Lista de Acoes
    * Data de Criacao: 06/11/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package imobCIEL
    * @subpackage
    *     
    * $Id$
    *     
    * Casos de uso: 
*/

include_once('../gabphp/env/env.php');
require_once(GBA_PATH_CLA_MAP . 'MPUsuario.class.php');

Sessao::controle();

$obHtml = new IHtml;
$divAreaGeral = new IDiv('areaGeral');
$obHtml->obBody->addComponente($divAreaGeral);
$obDesktop = new IDiv('areaTrabalho');
$divAreaGeral->addComponente($obDesktop);
include (GBA_PATH_INC . 'menu.php');

// Formulario

$obForm = new IFormulario();
$obForm->setAction('PRDadosPessoais.php');
$obForm->ativaTabela();

$obDesktop->addComponente($obForm);


// Nome

$obInpNome = new IInput('nomecompleto', $_SESSION['sessao']['nomecompleto'], 40, 80);
$obForm->addComponenteTabela('Nome', $obInpNome);


// E-mail

$obInpEmail = new IInput('email', $_SESSION['sessao']['email'], 40, 60);
$obForm->addComponenteTabela('E-mail', $obInpEmail);


// Telefone

$obInpTelefone = new IInput('telefone', $_SESSION['sessao']['telefone'], 15, 15);
$obForm->addComponenteTabela('Telefone', $obInpTelefone);


// Celular

$obInpCelular = new IInput('celular', $_SESSION['sessao']['celular'], 15, 15);
$obForm->addComponenteTabela('Celular', $obInpCelular);


// Usuario

$obInpUsuario = new IInput('nomeusuario', $_SESSION['sessao']['nomeusuario'], 20, 20);
$obForm->addComponenteTabela('Usuário', $obInpUsuario);


// Senha

$obInpSenha = new IInput('senhausuario', '', 15, 15);
$obInpSenha->setType('password');
$obForm->addComponenteTabela('Senha', $obInpSenha);


// Repita senha

$obInpRepitaSenha = new IInput('repitasenha', '', 15, 15);
$obInpRepitaSenha->setType('password');
$obForm->addComponenteTabela('Repita a Senha', $obInpRepitaSenha);


// Confirmar / Cancelar

$obConfirmarCancelar = new IConfirmarCancelar();

$obForm->addComponenteTabela('', $obConfirmarCancelar);

// Renderiza o HTML

$obHtml->renderizar();
?>