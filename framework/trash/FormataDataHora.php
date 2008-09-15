<?
// FormataDataHora
// 12/01/2007
function FormataDataHora($var)
{
	if ($var == '0000-00-00' || $var == '0000-00-00 00:00:00' || strlen($var) == 0)
	{
		$var = '';
	}
	else
	{
		// DateTime 
		if (strpos($var, ' '))
		{
			$cj = explode(' ', $var);
			$cjDt = explode('-', $cj[0]);
			$var = $cjDt[2] . '/' . $cjDt[1] . '/' . $cjDt[0] . ' ' . substr($cj[1], 0, 5) . 'h';
			unset ($cj, $cjDt);
		}
		// Date
		else
		{
			$cjDt = explode('-', $var);
			$var = $cjDt[2] . '/' . $cjDt[1] . '/' . $cjDt[0];
			unset ($cjDt);
		}
	}
	return $var;
}
?>