<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Classe de Componente de Interface HTML Label
    * Data de Criação: 10/04/2009
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: $
    *     
    * Casos de uso : 
*/
include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');
include_once (GBA_PATH_CLA_INT . 'IEvento.class.php');

class ILabel extends IComponenteBase
{

	function ILabel($stId='') {
		parent::IComponenteBase();
		$this->setTag('label');
		$this->stId = $stId;
	}

}
?>