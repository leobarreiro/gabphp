<?php
// 15/11/2006
// numGen.php
function NumGen($length=20)
{
	for ($i = 1; $i <= $length; $i++)
	{
		if ($i == 1)$randnum = rand(0, 9);
		else $randnum .= rand(0, 9);
	}
	return $randnum;
}
?>