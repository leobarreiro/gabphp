<?php
/**
 	* Framework GBAPHP
    * @license : GNU General License v.1
    * @link http://www.cielnews.com/gba
    * 
    * Pgina de Definio de Constantes do Sistema
    * Data de Criao: 14/11/2006
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: $
    *     
    * Casos de uso : 
*/

define("GBA_ERRORS", 123); // Para depuracao

error_reporting(GBA_ERRORS);

define("GBA_URL_BASE", 'http://localhost/');
define("GBA_PATH_BASE", '/home/sistemas/');

define("GBA_URL_SISTEMA", GBA_URL_BASE . 'gba/');
define("GBA_PATH_SISTEMA", GBA_PATH_BASE . 'gba/');

define("GBA_PATH_FWK", GBA_PATH_SISTEMA . 'framework/');

define("GBA_PATH_ENV", GBA_PATH_FWK . 'env/');
define("GBA_PATH_CLA", GBA_PATH_FWK . 'classes/');
define("GBA_PATH_CLA_EST", GBA_PATH_CLA . 'estatica/');
define("GBA_PATH_CLA_MAP", GBA_PATH_CLA . 'mapeamento/');
define("GBA_PATH_CLA_BDA", GBA_PATH_CLA . 'bancodados/');
define("GBA_PATH_CLA_CMP", GBA_PATH_CLA . 'componentes/');
define("GBA_PATH_CLA_INT", GBA_PATH_CLA . 'componentes/interface/');

// 27/01/2007

// Fpdf - Biblioteca para Gerar PDF

define("FPDF_FONTPATH", GBA_PATH_BASE . 'Fpdf/font/');

// RAP - Biblioteca para RDF com PHP
define("RDFAPI_INCLUDE_DIR", GBA_PATH_BASE . "rdfapi"); 

// Prefixo comum para todas as Constantes (SWB)

// Familia de Constantes para Banco de Dados (BD)

define("GBA_BD_HOST", 'localhost');
define("GBA_BD_USR", 'gba');  // Usuario Mestre para Conexao
define("GBA_BD_PW", '123456');
define("GBA_BD_NAME", 'cielnews_gba');  // Banco de Dados do Sistema

// FTP

define("GBA_FTP_HOST", 'localhost');
define("GBA_FTP_USR", 'leo');  // Usuario Mestre para Conexao
define("GBA_FTP_PW", 'fabi');
define("GBA_FTP_PASSIVE", 'true');
define("GBA_FTP_PATH", '/home/sistemas/gba/');
define("GBA_FTP_PATH_FOTOS", 'img/');

// Tabelas do Banco

define("GBA_BD_TEMPR", 'gba_empresa');
define("GBA_BD_TUSUA", 'gba_usuario');
define("GBA_BD_TSESS", 'gba_sessao');
define("GBA_BD_TLOGS", 'gba_log');
define("GBA_BD_TMODU", 'gba_modulo');
define("GBA_BD_TFUNC", 'gba_funcionalidade');
define("GBA_BD_TACAO", 'gba_acao');
define("GBA_BD_TUSAC", 'gba_usuario_acao');
define("GBA_BD_TEMMO", 'gba_empresa_modulo');

// Modulos do Sistema
// Valor 1=ativado 0=desativado

define("GBA_MODULO_ADMINISTRACAO", 1);
define("FNC_MODULO_COBRANCA", 1);
define("FNC_MODULO_CLIENTES", 1);
define('FNC_MODULO_SERVICOS', 1);

// Imagens
define("GBA_IMG_MAXWIDTH", 200);
define("GBA_IMG_MAXHEIGHT", 200);
define("GBA_IMG_MAXWEIGHT", 20000);

// Thumbnails
define("GBA_THUMB_MAXWIDTH", 80);
define("GBA_THUMB_MAXHEIGHT", 80);
define("GBA_THUMB_MAXWEIGHT", 2084);

// Diretorios Imagens
define("GBA_IMG_DIR_BASE", GBA_PATH_BASE . 'imagens/');
define("GBA_IMG_DIR_THUMBS", 'thumbs/'); // caminho relativo ao diretorio principal de imagens
define("GBA_IMG_FOTO_BORDA_EXT", 'black'); // 17/01/2007 - Cor da Borda Externa para Fotos
define("GBA_IMG_FOTO_BORDA_INT", 'white'); // 17/01/2007 - Cor da Borda Interna para Fotos
define("GBA_IMG_ETQ_FOTO", GBA_PATH_SISTEMA . 'images/etq.gif');
define("GBA_IMG_URL_BASE", GBA_URL_BASE . 'imagens_atusistemas/');

// Titulo de Paginas do Sistema

define("GBA_TITULO_PAGINA", 'GBAphp 0.1 beta');

// Familia de Constantes para Sessao (SE)
// Inatividade da Sessao
define("GBA_SE_INATIV", 60*60*10);

// Nome da Cookie
define("GBA_COOKIE_NAME", 'GbaPhp01'); 

// Validade do Sistema
define("GBA_VALIDADE_SISTEMA", '0000-00-00');

// Regionalizacao
define("GBA_FUSO_HORARIO", '0');

define('GBA_VERSION', 'GBAphp 0.1 beta');
?>