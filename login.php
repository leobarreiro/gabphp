<?php
/**
 	* Framework GABPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gab
    * 
    * Página de Login Padrão
    * Data de Criao: 21/06/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: login.php 46 2008-06-25 04:13:41Z leobba $
    *     
    * Casos de uso : 
*/

include_once ('./gabphp/env/env.php');

$obHtml = new IHtml;
$obHtml->obHead->addCSSArquivo('gabphp/css/gabphp.css');
$obHtml->obBody->setCss('bodyLogin');

$obDivLogo = new IDiv('logoLogin');
$obHtml->obBody->addComponente($obDivLogo);

$obForm = new IFormulario();
$obForm->setId('frmLogin');
$obForm->setNome('frmLogin');
$obForm->setAction('autenticar.php');

$obForm->obEvento->setOnSubmit("JsLogin()");


$obDiv1 = new IDiv();
$obDiv1->setCss('painelMsg');
$obTxtLogin = new ITexto('Entre com login e senha');
$obDiv1->addComponente($obTxtLogin);
$obHtml->obBody->addComponente($obDiv1);

$obDivLogin = new IDiv();
$obDivLogin->setId('dvLogin');

$obParUsuario = new ILabel();
$obLabelUsuario = new ISpan();
$obLabelUsuario->setCss('texto');
$obTxtUsuario = new ITexto('Usu&aacute;rio');
$obInputUsuario = new IInput('usuario', '', 20, 20);

$obLabelUsuario->addComponente($obTxtUsuario);
$obParUsuario->addComponente($obLabelUsuario);
$obParUsuario->addComponente($obInputUsuario);
$obDivLogin->addComponente($obParUsuario);

$obParSenha = new ILabel();
$obLabelSenha = new ISpan();
$obLabelSenha->setCss('texto');
$obTxtSenha = new ITexto('Senha');
$obInputSenha = new IInput('senha', '', 20, 20);
$obInputSenha->setType('password');

$obLabelSenha->addComponente($obTxtSenha);
$obParSenha->addComponente($obLabelSenha);
$obParSenha->addComponente($obInputSenha);
$obDivLogin->addComponente($obParSenha);

$obParOk = new IParagrafo();
$obInputOk = new IInput('entrar');
$obInputOk->setCss('botaoEntrar');
$obInputOk->setType('submit');
$obInputOk->setValue('Entrar');
$obInputOk->obEvento->setOnClick('JsLogin()');
$obParOk->addComponente($obInputOk);

$obDivLogin->addComponente($obParOk);
$obForm->addComponente($obDivLogin);
$obHtml->obBody->addComponente($obForm);

$obScript = new IScript;
$obScript->setType('text/javascript');
$obScript->setLanguage('Javascript');
$obScript->addFuncao('try {document.getElementById("usuario").focus();} catch(e){}');
$obHtml->obBody->addComponente($obScript);

$obHtml->show();
?>