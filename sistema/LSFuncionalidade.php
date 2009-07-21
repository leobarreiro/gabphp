<?
/**
 	* Framework GabPhp
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gab
    * 
    * Lista de Acoes
    * Data de Criacao: 12/07/2009
    * @author Leopoldo Braga Barreiro
    *     
    * @package GabPhp
    * @subpackage sistema
    *     
    * $Id$
    *     
    * Casos de uso: 
*/

require_once('../gabphp/env/env.php');
require_once(GBA_PATH_CLA_EST . 'Sistema.class.php');

Sessao::controle();

$obHtml = new IHtml;

$divAreaGeral = new IDiv('areaGeral');
$obHtml->obBody->addComponente($divAreaGeral);

include_once(GBA_PATH_INC . 'menu.php');

$obDesktop = new IDiv('areaTrabalho');
$obDesktop->setCss('areaTrab');
$divAreaGeral->addComponente($obDesktop);

// RecordSet

$obRecordSet = Sessao::recuperarRecordSet('funcionalidade');

// RecordSet Novo, sem consulta a Banco

if (!$obRecordSet || $obRecordSet->getLinhas() == 0)
{
	$obMap = new MPFuncionalidade;
	$obRecordSet = new RecordSet;
	
	// Definição de campos consultados
	$descricao = (isset($_REQUEST['descricao']) && strlen(strip_tags($_REQUEST['descricao'])) > 0) ? strip_tags(htmlentities($_REQUEST['descricao'])) : '';
	$codmodulo = (isset($_REQUEST['codmodulo']) && ((int) $_REQUEST['codmodulo'] > 0)) ? (int) $_REQUEST['codmodulo'] : 0;
	
	$obRecordSet->setResultados($obMap->executaListaFuncionalidadeGeral(array('codmodulo'=>$codmodulo, 'descricao'=>$descricao)));
	Sessao::gravarRecordSet('funcionalidade', $obRecordSet);
}

// Variavel de Controle de Paginacao

if (isset($_REQUEST['pg']))
{
	$inPg = (int) strip_tags($_REQUEST['pg']);
}
else
{
	$inPg = 1;
}

// Tabela com Paginação de Resultados

$obTbPaginacao = new ITabelaPaginacao;
$obTbPaginacao->setWidth('100%');
$obTbPaginacao->setChavesCampos( array('codigo', 'descricao', 'diretorio', 'prog', 'modulo') );
$obTbPaginacao->setCabecalho( array('Código', 'Descrição', 'Diretório', 'Programa', 'Módulo') );

$obTbPaginacao->setLinkEdicao('FCFuncionalidade.php');
$obTbPaginacao->setChavePrimaria('codigo');
$obTbPaginacao->setCamposEdicao( array('descricao', 'prog', 'diretorio') );

$obTbPaginacao->setPaginaAtual($inPg);
$obTbPaginacao->setLinhasPorPagina(GBA_RESULTADOS_POR_PAGINA);
$obTbPaginacao->addCSSCelulaResultado('modulo', 'resEsq');
$obTbPaginacao->addCSSCelulaResultado('ordem', 'resDir');

$obTbPaginacao->setRecordSet(Sessao::recuperarRecordSet('funcionalidade'));

$obDesktop->addComponente($obTbPaginacao);

// Renderização do HTML

$obHtml->renderizar();
?>