<?
// 15/01/2007
// Original do ImobCIEL

function CalculaData($dtOriginal, $d)
{
	$ano = substr($dtOriginal, 0, 4);
	$mes = substr($dtOriginal, 5, 2);
	$dia = substr($dtOriginal, 8, 2);
	$t = abs($d);
	$t = $t * 24;
	$t = $t * 60;
	$t = $t * 60;
	$unixtime = mktime(0, 0, 0, $mes, $dia, $ano);
	if ($d < 0)
	{
		$unixtime -= $t;
	}
	else
	{
		$unixtime += $t;
	}
	$montaData = date("Y-m-d", $unixtime);
	return $montaData;
}
?>