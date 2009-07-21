<?php
// FormataDataHora
// 12/01/2007
function FormataDateTime($var) {
	if ($var == '00/00/0000' || $var == '00/00/0000 00:00:00' || strlen($var) == 0) {
		$var = '';
	} else {
		// DateTime 
		if (strpos($var, ' ')) {
			$cj = explode(' ', $var);
			$cjDt = explode('/', $cj[0]);
			$var = $cjDt[2] . '-' . $cjDt[1] . '-' . $cjDt[0] . ' ' . $cj[1];
			unset ($cj, $cjDt);
		} else { // Date
			$cjDt = explode('/', $var);
			$var = $cjDt[2] . '-' . $cjDt[1] . '-' . $cjDt[0];
			unset ($cjDt);
		}
	}
	return $var;
}
?>