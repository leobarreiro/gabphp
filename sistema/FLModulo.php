<?
/**
 	* Framework GabPhp
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gab
    * 
    * Lista de Modulos
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

include_once ('../gabphp/env/env.php');

Sessao::controle();

$obHtml = new IHtml;

$divAreaGeral = new IDiv('areaGeral');
$obHtml->obBody->addComponente($divAreaGeral);

include_once(GBA_PATH_INC . 'menu.php');

$obDesktop = new IDiv('areaTrabalho');
$obDesktop->setCss('areaTrab');
$divAreaGeral->addComponente($obDesktop);

// Definicao do RecordSet na Sessao
// Inicializa o RecordSet

Sessao::gravarRecordSet('modulo', new RecordSet());

// Formulario de Pesquisa

$obForm = new IFormulario;
$obDesktop->addComponente($obForm);

$obForm->setAction('LSModulo.php');
$obForm->ativaTabela();

// Descricao do Modulo

$obInputDescricao = new IInput;
$obInputDescricao->setNomeId('descricao');
$obInputDescricao->setSize(40);
$obInputDescricao->setMaxLength(40);
$obForm->addComponenteTabela('Descrição', $obInputDescricao);

// Confirmar / Cancelar

$obInputConfCanc = new IConfirmarCancelar();
$obForm->addComponenteTabela(null, $obInputConfCanc);

// Renderiza o HTML

$obHtml->renderizar();
?>