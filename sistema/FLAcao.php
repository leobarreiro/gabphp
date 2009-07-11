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

Sessao::controle();

// Definicao do RecordSet na Sessao
// Inicializa o RecordSet

Sessao::gravarRecordSet('acao', new RecordSet());

$obHtml = new IHtml;
$divAreaGeral = new IDiv('areaGeral');
$obHtml->obBody->addComponente($divAreaGeral);
$obDesktop = new IDiv('areaTrabalho');
$divAreaGeral->addComponente($obDesktop);
include_once(GBA_PATH_INC . 'menu.php');

// Formulario de Pesquisa

$obForm = new IFormulario;
$obDesktop->addComponente($obForm);

$obForm->setAction('LSAcao.php');
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