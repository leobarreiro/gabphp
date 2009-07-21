<?php
// 14/11/2006
// Fazer Login leva o usu�rio at� a p�gina de login
function FazerLogin($oplogin=1)
{
	header("Cache-control: private");
	header("Location: " . ATU_URL_SISTEMA . "login.php?m=$oplogin");
}
?>