<?
// DefineCookie.php
// 17/01/2007
function DefineCookie($nome, $valor)
{
	$uriParts = parse_url(SWB_URL_SISTEMA);
	$cookiePath = substr($uriParts['path'], 0, strrpos($uriParts['path'], '/'));
	$isHttps = (isset($uriParts['scheme']) && $uriParts['scheme'] == 'https') ? 1 : 0;
	// Atenчуo!! Internet Explorer nem sempre aceita cookies com validade inferior a 24 horas.
	if (setcookie($nome, $valor, time()+SWB_SE_INATIV, $cookiePath, '', $isHttps))
	{
		$resposta = true;
	}
	else
	{
		$resposta = false;
	}
	return $resposta;
}
?>