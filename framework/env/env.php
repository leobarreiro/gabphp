<?php
/**
 * Framework GBAPHP
 * @license : GNU Lesser General Public License v.3
 * @link http://cielnews.com/gba
 * 
 * Página de Definição de Constantes do Sistema
 * Data de Referência: 14/11/2006
 * @author Leopoldo Braga Barreiro
 *     
 * @package GBA
 * @subpackage
 *     
 * $Id: $
 *     
 * Casos de uso : 
*/

define("GBA_ERRORS", 0); // Para depuracao

error_reporting(GBA_ERRORS);

define("GBA_URL_BASE", 'http://isengard/');
define("GBA_PATH_BASE", '/home/cielnews/public_html/');

define("GBA_URL_SISTEMA", GBA_URL_BASE . 'gba/');
define("GBA_PATH_SISTEMA", GBA_PATH_BASE . 'gba/');

define("GBA_PATH_FWK", GBA_PATH_BASE . 'gba/framework/');

define("GBA_PATH_ENV", GBA_PATH_FWK . 'env/');
define("GBA_PATH_CLA", GBA_PATH_FWK . 'classes/');
define("GBA_PATH_CLA_EST", GBA_PATH_CLA . 'estatica/');
define("GBA_PATH_CLA_MAP", GBA_PATH_CLA . 'mapeamento/');
define("GBA_PATH_CLA_BDA", GBA_PATH_CLA . 'bancodados/');
define("GBA_PATH_CLA_CMP", GBA_PATH_CLA . 'componentes/');
define("GBA_PATH_CLA_INT", GBA_PATH_CLA . 'componentes/interface/');
define ("GBA_PATH_CLA_WEB", GBA_PATH_CLA . 'web/');

// 27/01/2007

// Fpdf - Biblioteca para Gerar PDF

define("FPDF_FONTPATH", GBA_PATH_BASE . 'Fpdf/font/');

// RAP - Biblioteca para RDF com PHP
define("RDFAPI_INCLUDE_DIR", GBA_PATH_BASE . "rdfapi/api/"); 

// Prefixo comum para todas as Constantes (SWB)

// Familia de Constantes para Banco de Dados (BD)

define("GBA_BD_HOST", 'localhost');
define("GBA_BD_USR", 'cielnews_gba');  // Usuario Mestre para Conexao
define("GBA_BD_PW", 'zocotroco');
define("GBA_BD_NAME", 'cielnews_gba');  // Banco de Dados do Sistema

// FTP

define("GBA_FTP_HOST", 'localhost');
define("GBA_FTP_USR", 'cielnews_gba');
define("GBA_FTP_PW", 'zocotroco');
define("GBA_FTP_PASSIVE", 'true');
define("GBA_FTP_PATH", '/home/sistemas/gba/');
define("GBA_FTP_PATH_FOTOS", 'fotos/');

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


/* *******************************
 * Módulos do Sistema
 * ***************************** */

// Valor 1=ativado 0=desativado

define("GBA_MODULO_ADMINISTRACAO", 1);
define("GBA_MODULO_INFERENCIA", 1);

/* *******************************
 * Imagens
 * ***************************** */

// Arquivos de Imagem

// Diretorios Imagens

define("GBA_IMG_DIR_BASE", GBA_PATH_SISTEMA . 'fotos/');
define("GBA_IMG_URL_BASE", GBA_URL_SISTEMA . 'fotos/');

define("GBA_IMG_MAXWIDTH", 300);
define("GBA_IMG_MAXHEIGHT", 300);
define("GBA_IMG_MAXWEIGHT", 20000);

// Arquivos de Thumbnails

define("GBA_IMG_DIR_THUMBS", GBA_IMG_DIR_BASE . 'thumbs/');
define("GBA_IMG_URL_THUMBS", GBA_IMG_URL_BASE . 'thumbs/');

define("GBA_THUMB_MAXWIDTH", 80);
define("GBA_THUMB_MAXHEIGHT", 80);
define("GBA_THUMB_MAXWEIGHT", 2084);

// Tratamento de Imagens

define("GBA_IMG_FOTO_BORDA_EXT", 'black');
define("GBA_IMG_FOTO_BORDA_INT", 'white');
define("GBA_IMG_ETQ_FOTO", GBA_PATH_SISTEMA . 'img/etq.gif');


/* *******************************
 * Títulos
 * ***************************** */

// Titulo de Paginas do Sistema

define("GBA_TITULO_PAGINA", 'Framework GBA - Leopoldo Braga Barreiro - v0.2 beta');


/* *******************************
 * Sessão
 * ***************************** */

// Inatividade da Sessao

define("GBA_SE_INATIV", 60*60*10);

// Nome da Cookie

define("GBA_COOKIE_NAME", 'gbaFrmwrk'); 


/* *******************************
 * Regionalização
 * ***************************** */

define("GBA_FUSO_HORARIO", '0');
define("GBA_MOEDA_PADRAO", 'R$');
define("GBA_FORMATO_DATA", '%d/%m/%Y');


/* *******************************
 * Outras Configuracoes
 * ***************************** */

define("GBA_RESULTADOS_POR_PAGINA", 20);


/* *******************************
 * Versão do Sistema
 * ***************************** */

define('GBA_VERSION', 'GBA PHP Framework 0.2 beta');

// Validade do Sistema

define("GBA_VALIDADE_SISTEMA", '0000-00-00');
?>