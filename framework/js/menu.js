/**
 	* Framework GBA
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Javascript para controle de Menu do Sistema
    * Data de Criao: 12/10/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBA
    * @subpackage
    *     
    * $Id: $
    *     
    * Casos de uso : 
*/

function ShowMn(elem) {
	var OptMn = new Array();
	OptMn[0] = 'MnCliente';
	OptMn[1] = 'MnCobranca';
	OptMn[2] = 'MnServico';
	var e = 0;
	for (e=0; e<OptMn.length; e++) {
		try {
			document.getElementById(OptMn[e]).style.display='none';
			document.getElementById(OptMn[e]).style.visibility='hidden';
		} catch(e) {}
	}
	try {
		document.getElementById(elem).style.display='inline';
		document.getElementById(elem).style.visibility='visible';
	} catch(e) {}
}