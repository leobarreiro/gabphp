<?
// RemoveDir
// 13/01/2007

function RemoveDir($dir)
{
	$retorno = false;
	if (file_exists($dir) && is_dir($dir))
	{
		if ($abre = opendir($dir, "r"))
		{
			while (false != ($arq = readdir($abre)))
			{
				//if (is_dir($arq) && ($arq != "." && $arq != ".."))
				//{
				//	RemoveDir($arq);
				//}
				//else
				//{
					if (substr($dir, -1) == '/')
					{
						@unlink($dir . $arq);
					}
					else
					{
						@unlink($dir . '/' . $arq);
					}
				//}
			}
			$retorno = @rmdir($dir);
		}
		else
		{
			$retorno = 'Err1';
		}
	}
	else
	{
		$retorno = 'Err2';
	}
	return $retorno;
}
?>