<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Classe de Persistencia com Base de Dados
    * Data de Criacao: 05/01/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: $
    *     
    * Casos de uso : 
*/

include_once( GBA_PATH_CLA . 'Object.class.php' );
include_once( GBA_PATH_CLA_BDA . 'Conexao.class.php');

class Persistente extends Object {

var $obConexao; // Objeto do Tipo Conexao
var $stTabela;
var $arChavePrimaria;
var $arChaveEstrangeira;
var $arChaveUnica;
var $arCampos;
var $arTipos;
var $arValores;
var $boErro;
var $roConsulta;
var $inRegAfetados; // Quantidade de Registros Afetados
var $inRegSelecionados;
var $stDebug;
var $stSQL;
var $arTipoNumerico;
var $arTipoString;
var $arTipoData;
var $inInsertId;

function Persistente() {

	parent::__construct();
	$this->obConexao = new Conexao(GBA_BD_HOST, GBA_BD_USR, GBA_BD_PW, GBA_BD_NAME);
	$this->arChavePrimaria = array();
	$this->arChaveEstrangeira = array();
	$this->arCampos = array();
	$this->arTipos = array();
	$this->arValores = array();
	$this->boErro = true;
	$this->roConsulta = null;
	$this->inRegAfetados = 0;
	$this->inRegSelecionados = 0;
	$this->stDebug = 'Objeto ' . get_class($this) . ' instanciado';
	$this->stSQL = '';
	$this->arTipoString   = array('char', 'varchar', 'text', 'set');
	$this->arTipoData     = array('date', 'datetime', 'time', 'timestamp');
	$this->arTipoNumerico = array('int', 'decimal', 'float');
	$this->inInsertId = null;

}

function recuperaCamposTabela() {

	$this->arChavePrimaria = array();
	$this->arChaveEstrangeira = array();
	$this->arChaveUnica = array();
	$this->arCampos = array();
	$stSQL = "SHOW COLUMNS FROM `" . $this->getTabela() . "`";
	
	$trb = mysql_query($stSQL, $this->obConexao->getConexao());
	while ($registro = mysql_fetch_assoc($trb)) {
		if (strpos($registro['Type'], "(")) {
			$stTipo = substr($registro['Type'], 0, strpos($registro['Type'], "("));
		}
		else {
			$stTipo = $registro['Type'];
		}
		$this->addCampo($registro['Field'], $stTipo);
		$this->addValor($registro['Field'], '');

		if ($registro['Key'] == 'PRI') { $this->addChavePrimaria($registro['Field']); }
		if ($registro['Key'] == 'MUL') { $this->addChaveEstrangeira($registro['Field']); }
		if ($registro['Key'] == 'UNI') { $this->addChaveUnica($registro['Field']); }
	}
}

function setTabela($string) { $this->stTabela = $string; }
function setChavePrimaria($array) { $this->arChavePrimaria = $array; }
function setSQL($string) { $this->stSQL = $string; }

/**
 * @name  getTabela
 * @param void
 * @return String Nome da Tabela
*/
function getTabela() { return $this->stTabela; }
function getChavePrimaria() { return $this->stChavePrimaria; }
function getChaveUnica() { return $this->arChaveUnica; }

function getCampos() { return $this->arCampos; }
function getTipoCampo($stCampo) { return $this->arTipos[$stCampo]; }
function getValor($stCampo) { return $this->arValores[$stCampo]; }
function getInsertId() { return $this->inInsertId; }

function getRegAfetados() { return $this->inRegAfetados; }
function getRegSelecionados() { return $this->inRegSelecionados; }

function getConsulta() { return $this->roConsulta; }

function addCampo($stNome, $stTipo) {
	$this->arCampos[] = $stNome;
	$this->arTipos[$stNome] = $stTipo;
}

function addChavePrimaria($stNome) { $this->arChavePrimaria[] = $stNome; }
function addChaveEstrangeira($stNome) { $this->arChaveEstrangeira[] = $stNome; }
function addChaveUnica($stNome) { $this->arChaveUnica[] = $stNome; }
function addValor($stCampo, $stValor) { $this->arValores[$stCampo] = $stValor; }

/**
* @param void
* @return integer Insert ID
* @desc Insere o objeto no banco de dados. Retorna o Insert ID em caso de sucesso ou zero (0) em caso de falha na inser��o
* 
*/
function incluir() {
	$stSQL = "INSERT INTO ";
	// Tabela
	if (strlen($this->stTabela)) { $stSQL .= "`" . $this->getTabela() . "`"; }
	// Campos
	$stSQL .= " ( ";
	$stSQL .= implode(', ', $this->getCampos());
	$stSQL .= " ) ";
	// Valores
	$stSQL .= " VALUES ( ";
	foreach($this->getCampos() as $stCampo) {
		if (in_array($this->getTipoCampo($stCampo), $this->arTipoNumerico)) {
			if ($this->getValor($stCampo) == '') {
				$stSQL .= "'', ";
			} elseif (strtoupper($this->getValor($stCampo)) == 'NULL') {
				$stSQL .= "NULL, ";
			} else {
				$stSQL .= $this->getValor($stCampo) . ", ";
			}
		}
		else {
			if ($this->getValor($stCampo) == '') {
				$stSQL .= "'', ";
			} elseif (strtoupper($this->getValor($stCampo)) == 'NULL') {
				$stSQL .= "NULL, ";
			} else {
				$stSQL .= "'" . $this->getValor($stCampo) . "', ";
			}
		}
	}
	$stSQL = substr($stSQL, 0, (strlen($stSQL)-2));
	$stSQL .= " ) ";
	$this->stSQL = $stSQL;
	// Consulta
	$this->roConsulta = mysql_query($stSQL, $this->obConexao->getConexao());
	if (mysql_error($this->obConexao->getConexao())) {
		$this->stDebug = mysql_error($this->obConexao->getConexao());
	}
	if (mysql_affected_rows($this->obConexao->getConexao())) {
		$this->inRegAfetados = mysql_affected_rows($this->obConexao->getConexao());
		$this->inInsertId = mysql_insert_id($this->obConexao->getConexao());
		$inRetorno = $this->getInsertId();
	}
	else {
		$this->inRegAfetados = 0;
		$inRetorno = 0;
	}
	return $inRetorno;
}

/**
 * Recupera Registros no Banco de Dados
 * @return Resource Registros do Banco
*/

function recuperar() {

	$stSQL = "SELECT ";
	
	// Campos
	
	if (count($this->getCampos()) > 0) {
		
		$stSQL .= " " . implode(', ', $this->getCampos()) . " ";
		
	} else {
		
		$stSQL .= " * ";
		
	}
	
	
	// Tabela
	
	$stSQL .= " FROM `" . $this->getTabela() . "`";
	
	
	// Condicoes
	
	$stSQL .= " WHERE 1 ";
	
	foreach($this->arCampos as $stCampo) {
		
		if (strlen($this->getValor($stCampo)) > 0) {
			// Numerico
			if (in_array($this->getTipoCampo($stCampo), $this->arTipoNumerico)) {

				if (strtoupper($this->getValor($stCampo)) == 'NULL') {
					$stSQL .= " AND " . $stCampo . " IS NULL ";
				} else {
					$stSQL .= " AND " . $stCampo . " = " . $this->getValor($stCampo);
				}
			}
			else {

				if (strtoupper($this->getValor($stCampo)) == 'NULL') {
					$stSQL .= " AND " . $stCampo . " IS NULL ";
				} else {
					$stSQL .= " AND " . $stCampo . " = '" . $this->getValor($stCampo) . "'";
				}
			}
		}
		
	}
	
	$stSQL .= " ";
	$this->stSQL = $stSQL;
	
	// Consulta
	
	$this->roConsulta = mysql_query($stSQL, $this->obConexao->getConexao());
	
	if (mysql_error($this->obConexao->getConexao())) {
		$this->stDebug = mysql_error($this->obConexao->getConexao());
	}
	if (mysql_num_rows($this->roConsulta)) {
		$this->inRegSelecionados = mysql_num_rows($this->roConsulta);
	}
	else {
		$this->inRegSelecionados = 0;
	}
	
	return $this->roConsulta;

}


/**
* @param 	void
* @desc 	Altera um registro no banco
* @return 	integer: número de registros afetados com o UPDATE realizado no banco
* @todo 	Proporcionar que a alteração seja efetuada apenas nos campos que foram modificados do objeto. Atualmente modifica todos os campos descritos.
* */
function alterar() {

	$stSQL = "UPDATE ";
	// Tabela
	$stSQL .= " `" . $this->getTabela() . "`";
	// Campos
	$stSQL .= " SET ";
	foreach($this->arCampos as $stCampo) {
		if (strlen($this->getValor($stCampo)) > 0) {
			$stSQL .= $stCampo . " = '" . $this->getValor($stCampo) . "', ";
		}
		if (strtoupper($this->getValor($stCampo)) == 'NULL') {
			$stSQL .= $stCampo . " = NULL, ";
		}
	}
	$stSQL = substr($stSQL, 0, (strlen($stSQL)-2));
	// Condicoes
	$stSQL .= " WHERE 1 ";
	foreach($this->arChavePrimaria as $stCampo) {
		if (strlen($this->getValor($stCampo)) > 0) {
			// Numerico
			if (in_array($this->getTipoCampo($stCampo), $this->arTipoNumerico)) {

				if (strtoupper($this->getValor($stCampo)) == 'NULL') {
					$stSQL .= " AND " . $stCampo . " IS NULL ";
				} else {
					$stSQL .= " AND " . $stCampo . " = " . $this->getValor($stCampo);
				}
			}
			else {

				if (strtoupper($this->getValor($stCampo)) == 'NULL') {
					$stSQL .= " AND " . $stCampo . " IS NULL ";
				} else {
					$stSQL .= " AND " . $stCampo . " = '" . $this->getValor($stCampo) . "'";
				}
			}
		}
	}
	
	foreach($this->arChaveUnica as $stCampo) {
		if (strlen($this->getValor($stCampo)) > 0) {
			// Numerico
			if (in_array($this->getTipoCampo($stCampo), $this->arTipoNumerico)) {

				if (strtoupper($this->getValor($stCampo)) == 'NULL') {
					$stSQL .= " AND " . $stCampo . " IS NULL ";
				} else {
					$stSQL .= " AND " . $stCampo . " = " . $this->getValor($stCampo);
				}
			}
			else {

				if (strtoupper($this->getValor($stCampo)) == 'NULL') {
					$stSQL .= " AND " . $stCampo . " IS NULL ";
				} else {
					$stSQL .= " AND " . $stCampo . " = '" . $this->getValor($stCampo) . "'";
				}
			}
		}
	}
	
	$stSQL .= " ";
	$this->stSQL = $stSQL;
	
	// Consulta
	$this->roConsulta = mysql_query($stSQL, $this->obConexao->getConexao());
	if (mysql_error($this->obConexao->getConexao())) {
		$this->stDebug = mysql_error($this->obConexao->getConexao());
	}
	if (mysql_affected_rows($this->obConexao->getConexao())) {
		$this->inRegAfetados = mysql_affected_rows($this->obConexao->getConexao());
	}
	else {
		$this->inRegAfetados = 0;
	}
	
	return $this->getRegAfetados();

}

function excluir() {

	$stSQL = "DELETE ";
	// Tabela
	$stSQL .= " FROM `" . $this->getTabela() . "`";	
	// Condicoes
	$stSQL .= " WHERE 1 ";
	
	// Chave Primaria
	foreach($this->arChavePrimaria as $stCampo) {
		// Numerico
		if (in_array($this->getTipoCampo($stCampo), $this->arTipoNumerico)) {
			$stSQL .= " AND " . $stCampo . " = " . $this->getValor($stCampo);
		}
		else {
			$stSQL .= " AND " . $stCampo . " = '" . $this->getValor($stCampo) . "'";
		}
	}
	
	foreach($this->arChaveUnica as $stCampo) {
		// Numerico
		if (in_array($this->getTipoCampo($stCampo), $this->arTipoNumerico)) {
			$stSQL .= " AND " . $stCampo . " = " . $this->getValor($stCampo);
		}
		else {
			$stSQL .= " AND " . $stCampo . " = '" . $this->getValor($stCampo) . "'";
		}
	}
	
	$stSQL .= " ";
	$this->stSQL = $stSQL;
	
	// Consulta
	$this->roConsulta = mysql_query($stSQL, $this->obConexao->getConexao());
	if (mysql_error($this->obConexao->getConexao())) {
		$this->stDebug = mysql_error($this->obConexao->getConexao());
	}
	if (mysql_affected_rows($this->obConexao->getConexao())) {
		$this->inRegAfetados = mysql_affected_rows($this->obConexao->getConexao());
	}
	else {
		$this->inRegAfetados = 0;
	}
	
	return $this->inRegAfetados;

}

// Implementar em cada Classe Filha
function montaLista() {
	 return "SELECT * FROM `" . $this->getTabela() . "` ";
}

/**
* @param 	String ordemSQL
* @return 	Resource Consulta Banco
*/
function executaLista($ordemSQL='') {

	$this->stDebug = $this->montaLista();
	if (strlen($ordemSQL)) {
		$this->stDebug = $this->montaOrderBySQL($this->stDebug, $ordemSQL);
	}

	$this->roConsulta = $this->obConexao->executaSQL($this->stDebug);
	if ($this->obConexao->getErro() > 0) {
		$this->stDebug = $this->obConexao->getMsg();
		$this->roConsulta = null;
	}
	if (mysql_num_rows($this->roConsulta)) {
		$this->inRegSelecionados = mysql_num_rows($this->roConsulta);
	}
	else {
		$this->inRegSelecionados = 0;
	}

	return $this->roConsulta;

}


/**
* @param 	String Consulta SQL
* @return 	Resource Consulta Banco
*/
function executaSQL($stSQL) {

	if (strlen($stSQL)) {
		
		$this->stDebug = $stSQL;
		$this->roConsulta = $this->obConexao->executaSQL($this->stDebug);
		
		if ($this->obConexao->getErro() > 0) {
			$this->stDebug = $this->obConexao->getMsg();
			$this->roConsulta = null;
		}
		
		if (@mysql_num_rows($this->roConsulta)) {
			$this->inRegSelecionados = mysql_num_rows($this->roConsulta);
		} else {
			$this->inRegSelecionados = 0;
		}
		
		if (@mysql_affected_rows($this->roConsulta)) {
			$this->inRegAfetados = mysql_affected_rows($this->roConsulta);
		} else {
			$this->inRegAfetados = 0;
		}
		
	} else {
		
		$this->roConsulta = false;
		
	}
	
	return $this->roConsulta;
}

// Metodos de Utilidade Geral

function montaOrderBySQL($stSQL, $stOrder='') {
	$arMinus = array('select', 'from', 'where', ' as ', 'order');
	$arMaius = array('SELECT', 'FROM', 'WHERE', ' AS ', 'ORDER');
	$stSQL = str_replace($arMinus, $arMaius, $stSQL);
	// retira o ORDER
	if (strrpos($stSQL, 'ORDER')) {
		$stSQL = substr($stSQL, 0, strrpos($stSQL, 'ORDER'));
	}

	if (strlen($stOrder) > 0) {
		$stOrder = htmlentities($stOrder, ENT_QUOTES);
		$stAscDesc = substr($stOrder, -1, 1);
		if ($stAscDesc == '1' || $stAscDesc == '0') {
			$stCampoOrdem = substr($stOrder, 0, -1);
		}
		else {
			$stCampoOrdem = $stOrder;
		}

		if ($stAscDesc == '1') {
			$stAscDesc = 'DESC';
		}
		else {
			$stAscDesc = 'ASC';
		}
		$stOrderSQL = ' ORDER BY ' . $stCampoOrdem . ' ' . $stAscDesc;

		$stSQL .= $stOrderSQL;
	}

	return $stSQL;
}

public function preparaSQL($stSql) {
	
	$stSql = str_replace(array("\n", "\t", "\r"), array(" ", "", " "), $stSql);
	return $stSql;

}

}
?>
