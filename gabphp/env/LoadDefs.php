<?php
/**
 * Framework GBAPHP
 * @license : GNU Lesser General Public License v.3
 * @link http://cielnews.com/gba
 * 
 * Carregamento de Constantes e outros recursos
 * Data de Referência: 25/01/2008
 * @author Leopoldo Braga Barreiro
 *     
 * @package GBA
 * @subpackage
 *     
 * $Id: $
 *     
 * Casos de uso : 
*/

// variaveis de ambiente e variaveis especiais

error_reporting(GBA_ERRORS);

// includes básicas

include_once ( GBA_PATH_CLA_EST .'Sistema.class.php' );
include_once ( GBA_PATH_CLA_EST .'Sessao.class.php' );
include_once ( GBA_PATH_CLA_EST .'Cookie.class.php' );
include_once ( GBA_PATH_CLA_EST .'FusoHorario.class.php' );
include_once ( GBA_PATH_CLA_BDA .'RecordSet.class.php' );

// Verificar aqui a validade do sistema !!

?>