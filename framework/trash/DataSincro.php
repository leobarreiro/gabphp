<?
// 17/01/2007
// Revisar a Data do Sistema com a Data Remota
// Tratamento da Data de Validade do Sistema
if ($consultaData = @fopen('http://www.swbrasil.com/scripts/dataServidor.php', 'r'))
{
	$dataServidor = fgets($consultaData, 64);
	$dataSincro = 'swbrasil';
}
elseif ($consultaData = @fopen('http://www.cielnews.com/scripts/dataServidor.php', 'r'))
{
	$dataServidor = fgets($consultaData, 64);
	$dataSincro = 'cielnews';
}
else
{
	$dataServidor = date("Y-m-d");
	$dataSincro = 'intranet';
}
// Redireciona em caso de Expiraчуo
if ($dataServidor > SWB_VALIDADE_SISTEMA)
{
	header ("Location: " . SWB_URL_SISTEMA . "/sair.php");
}
?>