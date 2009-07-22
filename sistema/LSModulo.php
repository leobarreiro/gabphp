<?
/**
 	* Framework GabPhp
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gab
    * 
    * Lista de Acoes
    * Data de Criacao: 21/07/2009
    * @author Leopoldo Braga Barreiro
    *     
    * @package GabPhp
    * @subpackage sistema
    *     
    * $Id$
    *     
    * Casos de uso: Listar Modulos
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

$obRecordSet = Sessao::recuperarRecordSet('modulo');

// RecordSet Novo, sem consulta a Banco

if (!$obRecordSet || $obRecordSet->getLinhas() == 0)
{
	$obMap = new MPModulo;
	$obRecordSet = new RecordSet;
	
	// Definição de campos consultados
	$descricao = (isset($_REQUEST['descricao']) && strlen(strip_tags($_REQUEST['descricao'])) > 0) ? strip_tags(htmlentities($_REQUEST['descricao'])) : '';
	
	$obRecordSet->setResultados($obMap->executaListaModuloGeral(array('descricao'=>$descricao)));
	Sessao::gravarRecordSet('modulo', $obRecordSet);
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
$obTbPaginacao->setChavesCampos(array('codigo', 'descricao', 'diretorio'));
$obTbPaginacao->setCabecalho(array('Código', 'Descrição', 'Diretório'));

$obTbPaginacao->setLinkEdicao('FCModulo.php');
$obTbPaginacao->setChavePrimaria('codigo');
$obTbPaginacao->setCamposEdicao(array('descricao', 'diretorio'));

$obTbPaginacao->setPaginaAtual($inPg);
$obTbPaginacao->setLinhasPorPagina(GBA_RESULTADOS_POR_PAGINA);
$obTbPaginacao->setRecordSet(Sessao::recuperarRecordSet('modulo'));

$obDesktop->addComponente($obTbPaginacao);

// Renderização do HTML

$obHtml->renderizar();
?>