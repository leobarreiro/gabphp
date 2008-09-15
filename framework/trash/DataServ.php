<?
// 27/01/2007
// DataServ.php
// Retorna a Data do Servidor com o recálculo para Hora Local
function DataServ()
{
	global $swb;	
	$dataHora = date("d/m/y H:i") . 'h.';
	$diasSemana = $swb['dias_semana'];
	$diaSemana = $diasSemana[date("w")];
	return $diaSemana . ', ' . $dataHora;
}
?>