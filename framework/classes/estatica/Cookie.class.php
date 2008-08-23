<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Classe Estсtica de Cookie
    * Data de Criaчуo: 25/01/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: $
    *     
    * Casos de uso : 
*/

class Cookie {

function cria($stNomeCookie, $stValidadeCookie=0, $stValor=false) {

	$boRetorno = false;

	if (strlen($stNomeCookie)) {
		$uriParts = parse_url( GBA_URL_SISTEMA );
		$cookiePath   = substr($uriParts['path'], 0, strrpos($uriParts['path'], '/'));
		$isHttps = (isset($uriParts['scheme']) && $uriParts['scheme'] == 'https') ? 1 : 0;
		$boRetorno = setcookie( $stNomeCookie, $stValor, time()+$stValidadeCookie, $cookiePath, '', $isHttps );
	}
	return $boRetorno;
}


function destroi($stNomeCookie) {
	
	$boRetorno = false;
	
	if (strlen($stNomeCookie)) {
		$uriParts = parse_url( GBA_URL_SISTEMA );
		//$cookiePath   = substr($uriParts['path'], 0, strrpos($uriParts['path'], '/'));
		$cookiePath = "/";
		$isHttps = (isset($uriParts['scheme']) && $uriParts['scheme'] == 'https') ? 1 : 0;
		if (setcookie( $stNomeCookie, false, time()-GBA_SE_INATIV, $cookiePath, '', $isHttps )) {
			$boRetorno = true;
		}
	}
	return $boRetorno;
}


}
?>