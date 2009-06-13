<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
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

include_once ('framework/env/env.php');
include_once ('framework/env/LoadDefs.php');
include_once(GBA_PATH_CLA_CMP . "LoadClasses.php");

$obHtml = new IHtml;
$obHtml->obHead->addCSSArquivo('framework/css/gbaphp.css');
$obHtml->obBody->setCss('bodyLogin');

$obForm = new IFormulario();
$obForm->setId('frmLogin');
$obForm->setNome('frmLogin');
$obForm->setAction('autenticar.php');

$obForm->obEvento->setOnSubmit("JsLogin()");

$obDivLogo = new IDiv('logoLogin');
$obHtml->obBody->addComponente($obDivLogo);

$obDiv1 = new IDiv();
$obDiv1->setCss('painelMsg');
$obTxtLogin = new ITexto('Entre com login e senha');
$obDiv1->addComponente($obTxtLogin);
$obHtml->obBody->addComponente($obDiv1);

$obDivLogin = new IDiv();
$obDivLogin->setId('dvLogin');

$obParUsuario = new IParagrafo();
$obLabelUsuario = new IDiv();
$obLabelUsuario->setCss('texto');
$obTxtUsuario = new ITexto('Usu&aacute;rio');
$obInputUsuario = new IInput('usuario', '', 20, 20);

$obLabelUsuario->addComponente($obTxtUsuario);
$obParUsuario->addComponente($obLabelUsuario);
$obParUsuario->addComponente($obInputUsuario);
$obDivLogin->addComponente($obParUsuario);

$obParSenha = new IParagrafo();
$obLabelSenha = new IDiv();
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


/*
$obCel3 = new ICelula();
$obTxtSenha = new ITexto('Senha');
$obCel3->addComponente($obTxtSenha);
$obTabela->addCelula($obCel3, true);

$obCel4 = new ICelula();
$obInputSenha = new IInput('senha', '', 20, 20);
$obInputSenha->setType('password');
$obCel4->addComponente($obInputSenha);
$obTabela->addCelula($obCel4);

$obCel5 = new ICelula('100%', 'center');
$obCel5->setColspan(2);



$obCel5->addComponente($obInputOk);
$obTabela->addCelula($obCel5, true);

$obForm->addComponente($obTabela);
$obHtml->obBody->addComponente($obForm);
*/

$obScript = new IScript;
$obScript->setType('text/javascript');
$obScript->setLanguage('Javascript');
$obScript->addFuncao('try {document.getElementById("usuario").focus();} catch(e){}');
$obHtml->obBody->addComponente($obScript);

$obHtml->show();
?>