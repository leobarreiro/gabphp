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
    * $Id: $
    *     
    * Casos de uso: 
*/


include_once('../env/env.php');
include_once ( GBA_PATH_ENV . 'LoadDefs.php');
include_once(GBA_PATH_CLA_CMP . "LoadClasses.php");

Sessao::controle();

// Definicao do RecordSet na Sessao
// Inicializa o RecordSet

Sessao::gravarRecordSet('acao', new RecordSet());


$obHtml = new IHtml;
$obHtml->obHead->addCSSArquivo("../css/tcc.css");
$obHtml->obHead->setCharset('UTF-8');

include_once(GBA_PATH_SISTEMA . 'include/menu.php');

// Cria a Area de Trabalho

$obDesktop = new IDiv('areaTrabalho');
$obHtml->obBody->addComponente($obDesktop);

// Formulario de Pesquisa

$obForm = new IFormulario;
$obDesktop->addComponente($obForm);

$obForm->setAction('LSListarAcao.php');
$obForm->ativaTabela();

// Descricao

$obInputDescricao = new IInput;
$obInputDescricao->setNomeId('descricao');
$obInputDescricao->setSize(40);
$obForm->addComponenteTabela('Descrição', $obInputDescricao);

// Confirmar / Cancelar

$obInputConfCanc = new IConfirmarCancelar();
$obForm->addComponenteTabela(null, $obInputConfCanc);

// Renderiza o HTML

$obHtml->renderizar();
?>