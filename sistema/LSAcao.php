<?
/**
 	* Sistema imobCIEL
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/imobciel
    * 
    * Lista de Acoes
    * Data de Criacao: 29/09/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package imobCIEL
    * @subpackage
    *     
    * $Id$
    *     
    * Casos de uso: 
*/

include_once ('../gabphp/env/env.php');
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

$obRecordSet = Sessao::recuperarRecordSet('acao');

// RecordSet Novo, sem consulta a Banco

if (!$obRecordSet || $obRecordSet->getLinhas() == 0)
{
	$obMap = new MPAcao;
	$obRecordSet = new RecordSet;
	
	// Campos do formulário que estão sendo tratados para a consulta
	
	$descricao = (isset($_REQUEST['descricao'])) ? (string) strip_tags($_REQUEST['descricao']) : '';
	$codmodulo = (isset($_REQUEST['codmodulo'])) ? (int) strip_tags($_REQUEST['codmodulo']) : 0;
	$codfuncionalidade = (isset($_REQUEST['codfuncionalidade'])) ? (int) strip_tags($_REQUEST['codfuncionalidade']) : 0;

	// Executar a consulta
	
	$obRecordSet->setResultados($obMap->executaListaAcaoGeral(array('descricao'=>$descricao, 'codmodulo'=>$codmodulo, 'codfuncionalidade'=>$codfuncionalidade)));
	Sessao::gravarRecordSet('acao', $obRecordSet);
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
$obTbPaginacao->setChavesCampos( array('codigo', 'descricao', 'prog', 'ordem', 'funcionalidade', 'modulo') );
$obTbPaginacao->setCabecalho( array('Código', 'Descrição', 'Programa', 'Ordem', 'Funcionalidade', 'Módulo') );
$obTbPaginacao->setLinkEdicao('FCAcao.php');
$obTbPaginacao->setChavePrimaria('codigo');
$obTbPaginacao->setCamposEdicao( array('descricao', 'prog', 'codigo') );
$obTbPaginacao->setPaginaAtual($inPg);
$obTbPaginacao->setLinhasPorPagina(GBA_RESULTADOS_POR_PAGINA);
$obTbPaginacao->addCSSCelulaResultado('modulo', 'resEsq');
$obTbPaginacao->addCSSCelulaResultado('ordem', 'resDir');
$obTbPaginacao->setRecordSet(Sessao::recuperarRecordSet('acao'));

$obDesktop->addComponente($obTbPaginacao);

// Renderização do HTML

$obHtml->renderizar();
?>