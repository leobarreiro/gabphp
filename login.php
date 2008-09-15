<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Pgina de Login Padro
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
$obHtml->obHead->setUrlCssFile('framework/css/gbaphp.css');

$obForm = new IFormulario();
$obForm->setId('frmLogin');
$obForm->setNome('frmLogin');
$obForm->setAction('autenticar.php');

$obForm->obEvento->setOnSubmit("JsLogin()");

$obImgLogo = new IImg('framework/images/logo.png', 'Login');
$obImgLogo->setId('logoLogin');
$obHtml->obBody->addComponente($obImgLogo);

$obDiv1 = new IDiv();
$obDiv1->setId('painelMsg');
$obTxtLogin = new ITexto('Entre com login e senha');
$obDiv1->addComponente($obTxtLogin);

$obHtml->obBody->addComponente($obDiv1);

$obTabela = new ITabela();
$obTabela->setId('tbLogin');

$obCel1 = new ICelula();
$obTextoUsuario = new ITexto('Usu&aacute;rio');
$obCel1->addComponente($obTextoUsuario);
$obTabela->addCelula($obCel1, true);

$obCel2 = new ICelula(); 
$obInputUsuario = new IInput('usuario', '', 20, 20);
$obCel2->addComponente($obInputUsuario);
$obTabela->addCelula($obCel2);

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

$obInputOk = new IInput('entrar');
$obInputOk->setType('submit');
$obInputOk->setValue('Entrar');
$obInputOk->obEvento->setOnClick('JsLogin()');

$obCel5->addComponente($obInputOk);
$obTabela->addCelula($obCel5, true);

$obForm->addComponente($obTabela);
$obHtml->obBody->addComponente($obForm);

$obScript = new IScript;
$obScript->setType('text/javascript');
$obScript->setLanguage('Javascript');
$obScript->addFuncao('try {document.getElementById("usuario").focus();} catch(e){}');
$obHtml->obBody->addComponente($obScript);

$obHtml->show();
?>