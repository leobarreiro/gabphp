<?php
/*
* AtualizaDataHora.php
*/
include ('../Env/env.php');
error_reporting(GBA_ERRORS);
header("Content-Type: text/html; charset=ISO-8859-1",true);

if (isset($_COOKIE[GBA_COOKIE_NAME])) {
	include_once ('../Classes/Estatica/Sistema.class.php');
	include_once ('../Classes/Estatica/FusoHorario.class.php');
	$retorno = Sistema::dataServ();
} else {
	$retorno = '';
}
echo $retorno;
?>