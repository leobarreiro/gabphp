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


include_once('../gabphp/env/env.php');

// Inclusao da Classe de Mapeamento para Acao
include_once(GBA_PATH_CLA_MAP . 'MPAcao.class.php');

Sessao::controle();

$obHtml = new IHtml;
$divAreaGeral = new IDiv('areaGeral');
$obHtml->obBody->addComponente($divAreaGeral);
$obDesktop = new IDiv('areaTrabalho');
$divAreaGeral->addComponente($obDesktop);
include_once(GBA_PATH_INC . 'menu.php');

// RecordSet

$obRecordSet = Sessao::recuperarRecordSet('acao');

// RecordSet Novo, sem consulta a Banco

if (!$obRecordSet || $obRecordSet->getLinhas() == 0)
{
	$obMap = new MPAcao;
	$obRecordSet = new RecordSet;
	$obRecordSet->setResultados($obMap->recuperar());
	// RecordSet - Gravar na Sessao
	Sessao::gravarRecordSet('acao', $obRecordSet);
}

// Variavel de Controle de Paginacao

if (isset($_GET['pg']))
{
	$inPg = (int) strip_tags($_GET['pg']);
}
else
{
	$inPg = 1;
}

// Tabela com Paginação de Resultados

$obTbPaginacao = new ITabelaPaginacao;
$obTbPaginacao->setChavesCampos( array('codacao', 'descricao', 'programa', 'parametro', 'codmodulo', 'codfuncionalidade', 'ordem') );
$obTbPaginacao->setCabecalho( array('Código', 'Descrição', 'Programa', 'Parâmetro', 'Módulo', 'Funcionalidade', 'Ordem') );

$obTbPaginacao->setLinkEdicao('FCAcao.php');
$obTbPaginacao->setChavePrimaria('codacao');
$obTbPaginacao->setCamposEdicao( array('descricao', 'programa', 'codacao') );

$obTbPaginacao->setPaginaAtual($inPg);
$obTbPaginacao->setLinhasPorPagina(GBA_RESULTADOS_POR_PAGINA);

$obTbPaginacao->addCSSCelulaResultado('codmodulo', 'resEsq');
$obTbPaginacao->addCSSCelulaResultado('ordem', 'resDir');

$obTbPaginacao->setRecordSet(Sessao::recuperarRecordSet('acao'));

$obDesktop->addComponente($obTbPaginacao);

// Renderização do HTML

$obHtml->renderizar();
?>