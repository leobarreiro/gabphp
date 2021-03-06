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
	
	public $obConexao; // Objeto do Tipo Conexao
	public $stTabela;
	public $arChavePrimaria;
	public $arChaveEstrangeira;
	public $arChaveUnica;
	public $arCampos;
	public $arPermiteNulo; // Campos que permitem valores nulos
	public $arTipos;
	public $arValores;
	public $boErro;
	public $roConsulta;
	public $inRegAfetados; // Quantidade de Registros Afetados
	public $inRegSelecionados;
	public $stDebug;
	public $stSQL;
	public $arTipoNumerico;
	public $arTipoString;
	public $arTipoData;
	public $inInsertId;
	
	public function Persistente()
	{
		parent::__construct();
		$this->obConexao = new Conexao(GBA_BD_HOST, GBA_BD_USR, GBA_BD_PW, GBA_BD_NAME);
		$this->arChavePrimaria = array();
		$this->arChaveEstrangeira = array();
		$this->arCampos = array();
		$this->arPermiteNulo = array();
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
	
	public function recuperaCamposTabela()
	{
		$this->arChavePrimaria = array();
		$this->arChaveEstrangeira = array();
		$this->arChaveUnica = array();
		$this->arCampos = array();
		$this->arPermiteNulo = array();
		$stSQL = "SHOW COLUMNS FROM `" . $this->getTabela() . "`";	
		$trb = mysql_query($stSQL, $this->obConexao->getConexao());
		while ($registro = mysql_fetch_assoc($trb))
		{
			if (strpos($registro['Type'], "("))
			{
				$stTipo = substr($registro['Type'], 0, strpos($registro['Type'], "("));
			}
			else
			{
				$stTipo = $registro['Type'];
			}
			$this->addCampo($registro['Field'], $stTipo);
			$this->addValor($registro['Field'], '');
			if ($registro['Key'] == 'PRI') { $this->addChavePrimaria($registro['Field']); }
			if ($registro['Key'] == 'MUL') { $this->addChaveEstrangeira($registro['Field']); }
			if ($registro['Key'] == 'UNI') { $this->addChaveUnica($registro['Field']); }
			if ($registro['Null'] == 'YES') { $this->addPermiteNulo($registro['Field']); }
		}
	}
	
	public function setTabela($string)
	{
		$this->stTabela = $string;
	}
	public function setChavePrimaria($array)
	{
		$this->arChavePrimaria = $array;
	}
	
	public function setSQL($string)
	{
		$this->stSQL = $string;
	}
	
	/**
	 * @name  getTabela
	 * @param void
	 * @return String Nome da Tabela
	*/
	public function getTabela()
	{
		return $this->stTabela;
	}
	
	public function getChavePrimaria()
	{
		return $this->stChavePrimaria;
	}
	
	public function getChaveUnica()
	{
		return $this->arChaveUnica;
	}
	
	public function getCampos()
	{
		return $this->arCampos;
	}
	
	public function getTipoCampo($stCampo)
	{
		return $this->arTipos[$stCampo];
	}
	
	public function getValor($stCampo)
	{
		return $this->arValores[$stCampo];
	}
	
	public function getInsertId()
	{
		return $this->inInsertId;
	}
	
	public function getRegAfetados()
	{
		return $this->inRegAfetados;
	}
	
	public function getRegSelecionados()
	{
		return $this->inRegSelecionados;
	}
	
	public function getConsulta()
	{
		return $this->roConsulta;
	}
	
	public function addCampo($stNome, $stTipo)
	{
		$this->arCampos[] = $stNome;
		$this->arTipos[$stNome] = $stTipo;
	}
	
	public function addChavePrimaria($stNome)
	{
		$this->arChavePrimaria[] = $stNome;
	}
	
	public function addChaveEstrangeira($stNome)
	{
		$this->arChaveEstrangeira[] = $stNome;
	}
	
	public function addChaveUnica($stNome)
	{
		$this->arChaveUnica[] = $stNome;
	}
	
	public function addPermiteNulo($stNome)
	{
		$this->arPermiteNulo[] = $stNome;
	}
	
	public function addValor($stCampo, $stValor)
	{
		$this->arValores[$stCampo] = $stValor;
	}
	
	/**
	* @param void
	* @return integer Insert ID
	* @desc Insere o objeto no banco de dados. Retorna o Insert ID em caso de sucesso ou zero (0) em caso de falha na insercao
	* 
	*/
	public function incluir()
	{
		$stSQL = "INSERT INTO ";
		// Tabela
		if (strlen($this->stTabela))
		{
			$stSQL .= "`" . $this->getTabela() . "`";
		}
		// Campos
		$stSQL .= " ( ";
		$stSQL .= implode(', ', $this->getCampos());
		$stSQL .= " ) ";
		// Valores
		$stSQL .= " VALUES ( ";
		foreach($this->getCampos() as $stCampo)
		{
			if (in_array($this->getTipoCampo($stCampo), $this->arTipoNumerico))
			{
				if ($this->getValor($stCampo) == '')
				{
					$stSQL .= "'', ";
				}
				elseif (strtoupper($this->getValor($stCampo)) == 'NULL')
				{
					$stSQL .= "NULL, ";
				}
				else
				{
					$stSQL .= $this->getValor($stCampo) . ", ";
				}
			}
			else
			{
				if ($this->getValor($stCampo) == '')
				{
					$stSQL .= "'', ";
				}
				elseif (strtoupper($this->getValor($stCampo)) == 'NULL')
				{
					$stSQL .= "NULL, ";
				}
				else
				{
					$stSQL .= "'" . $this->getValor($stCampo) . "', ";
				}
			}
		}
		$stSQL = substr($stSQL, 0, (strlen($stSQL)-2));
		$stSQL .= " ) ";
		
		$stSQL = $this->preparaSQL($stSQL);
		$this->stSQL = $stSQL;
		//$this->logMsg($stSQL);
		
		// Consulta
		$this->roConsulta = mysql_query($stSQL, $this->obConexao->getConexao());
		if (mysql_error($this->obConexao->getConexao()))
		{
			$this->stDebug = mysql_error($this->obConexao->getConexao());
			$this->setErro($this->stDebug, true);
			$this->logError();
		}
		if (mysql_affected_rows($this->obConexao->getConexao()))
		{
			$this->inRegAfetados = mysql_affected_rows($this->obConexao->getConexao());
			$this->inInsertId = mysql_insert_id($this->obConexao->getConexao());
			$inRetorno = $this->getInsertId();
		}
		else
		{
			$this->inRegAfetados = 0;
			$inRetorno = 0;
		}
		return $inRetorno;
	}
	
	/**
	 * Recupera Registros no Banco de Dados
	 * @return Resource Registros do Banco
	*/
	
	public function recuperar()
	{
		$stSQL = "SELECT ";
		if (count($this->getCampos()) > 0)
		{	
			$stSQL .= " " . implode(', ', $this->getCampos()) . " ";	
		}
		else
		{	
			$stSQL .= " * ";
		}
		$stSQL .= " FROM `" . $this->getTabela() . "`";
		$stSQL .= " WHERE 1 ";
		foreach ($this->arCampos as $stCampo)
		{	
			if (strlen($this->getValor($stCampo)) > 0)
			{
				// Numerico
				if (in_array($this->getTipoCampo($stCampo), $this->arTipoNumerico))
				{
					if (strtoupper($this->getValor($stCampo)) == 'NULL')
					{
						$stSQL .= " AND " . $stCampo . " IS NULL ";
					}
					else
					{
						$stSQL .= " AND " . $stCampo . " = " . $this->getValor($stCampo);
					}
				}
				else
				{
					if (strtoupper($this->getValor($stCampo)) == 'NULL')
					{
						$stSQL .= " AND " . $stCampo . " IS NULL ";
					}
					else
					{
						$stSQL .= " AND " . $stCampo . " = '" . $this->getValor($stCampo) . "'";
					}
				}
			}
		}
		$stSQL .= " ";
		
		$stSQL = $this->preparaSQL($stSQL);
		$this->stSQL = $stSQL;
		//$this->logMsg($stSQL);
		
		// Consulta
		$this->roConsulta = mysql_query($stSQL, $this->obConexao->getConexao());
		if (mysql_error($this->obConexao->getConexao()))
		{
			$this->stDebug = mysql_error($this->obConexao->getConexao());
			$this->setErro($this->stDebug, true);
			$this->logError();
		}
		if (mysql_num_rows($this->roConsulta))
		{
			$this->inRegSelecionados = mysql_num_rows($this->roConsulta);
		}
		else
		{
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
	public function alterar()
	{
		$stSQL = "UPDATE ";
		$stSQL .= " `" . $this->getTabela() . "`";
		$stSQL .= " SET ";
		foreach ($this->arCampos as $stCampo)
		{
			if (!in_array($stCampo, $this->arChavePrimaria))
			{
				if (strlen($this->getValor($stCampo)) > 0)
				{
					$stSQL .= $stCampo . " = '" . $this->getValor($stCampo) . "', ";
				}
				if (strtoupper($this->getValor($stCampo)) == 'NULL')
				{
					$stSQL .= $stCampo . " = NULL, ";
				}
			}
		}
		$stSQL = substr($stSQL, 0, (strlen($stSQL)-2));
		$stSQL .= " WHERE 1 ";
		foreach ($this->arChavePrimaria as $stCampo)
		{
			if (strlen($this->getValor($stCampo)) > 0)
			{
				// Numerico
				if (in_array($this->getTipoCampo($stCampo), $this->arTipoNumerico))
				{
					if (strtoupper($this->getValor($stCampo)) == 'NULL')
					{
						$stSQL .= " AND " . $stCampo . " IS NULL ";
					}
					else
					{
						$stSQL .= " AND " . $stCampo . " = " . $this->getValor($stCampo);
					}
				}
				else
				{
					if (strtoupper($this->getValor($stCampo)) == 'NULL')
					{
						$stSQL .= " AND " . $stCampo . " IS NULL ";
					}
					else
					{
						$stSQL .= " AND " . $stCampo . " = '" . $this->getValor($stCampo) . "'";
					}
				}
			}
		}
		/*
		foreach ($this->arChaveUnica as $stCampo)
		{
			if (strlen($this->getValor($stCampo)) > 0)
			{
				// Numerico
				if (in_array($this->getTipoCampo($stCampo), $this->arTipoNumerico))
				{
					if (strtoupper($this->getValor($stCampo)) == 'NULL')
					{
						$stSQL .= " AND " . $stCampo . " IS NULL ";
					}
					else
					{
						$stSQL .= " AND " . $stCampo . " = " . $this->getValor($stCampo);
					}
				}
				else
				{
					if (strtoupper($this->getValor($stCampo)) == 'NULL')
					{
						$stSQL .= " AND " . $stCampo . " IS NULL ";
					}
					else
					{
						$stSQL .= " AND " . $stCampo . " = '" . $this->getValor($stCampo) . "'";
					}
				}
			}
		}*/
		
		$stSQL .= " ";
		$this->stSQL = $stSQL;
		
		$stSQL = $this->preparaSQL($stSQL);
		//$this->logMsg($stSQL);
		
		// Consulta
		$this->roConsulta = mysql_query($stSQL, $this->obConexao->getConexao());
		if (mysql_error($this->obConexao->getConexao()))
		{
			$this->stDebug = mysql_error($this->obConexao->getConexao());
			$this->setErro($this->stDebug, true);
			$this->logError();
		}
		if (mysql_affected_rows($this->obConexao->getConexao()))
		{
			$this->inRegAfetados = mysql_affected_rows($this->obConexao->getConexao());
		}
		else
		{
			$this->inRegAfetados = 0;
		}
		return $this->getRegAfetados();
	}
	
	public function excluir()
	{
		$stSQL = "DELETE ";
		$stSQL .= " FROM `" . $this->getTabela() . "`";	
		$stSQL .= " WHERE 1 ";	
		// Chave Primaria
		foreach($this->arChavePrimaria as $stCampo)
		{
			// Numerico
			if (in_array($this->getTipoCampo($stCampo), $this->arTipoNumerico))
			{
				$stSQL .= " AND " . $stCampo . " = " . $this->getValor($stCampo);
			}
			else
			{
				$stSQL .= " AND " . $stCampo . " = '" . $this->getValor($stCampo) . "'";
			}
		}
		foreach ($this->arChaveUnica as $stCampo)
		{
			// Numerico
			if (in_array($this->getTipoCampo($stCampo), $this->arTipoNumerico) && $this->getValor($stCampo) > 0)
			{
				$stSQL .= " AND " . $stCampo . " = " . $this->getValor($stCampo);
			}
			else
			{
				if (strlen($this->getValor($stCampo)) > 0)
				{
					$stSQL .= " AND " . $stCampo . " = '" . $this->getValor($stCampo) . "'";
				}
			}
		}
		$stSQL .= " ";
		
		$stSQL = $this->preparaSQL($stSQL);
		$this->stSQL = $stSQL;
		//$this->logMsg($stSQL);
		
		// Consulta
		$this->roConsulta = mysql_query($stSQL, $this->obConexao->getConexao());
		if (mysql_error($this->obConexao->getConexao()))
		{
			$this->stDebug = mysql_error($this->obConexao->getConexao());
			$this->setErro($this->stDebug, true);
			$this->logError();
		}
		if (mysql_affected_rows($this->obConexao->getConexao()))
		{
			$this->inRegAfetados = mysql_affected_rows($this->obConexao->getConexao());
		}
		else
		{
			$this->inRegAfetados = 0;
		}
		return $this->inRegAfetados;
	}
	
	// Implementar em cada Classe Filha
	public function montaLista()
	{
		return "SELECT * FROM `" . $this->getTabela() . "` ";
	}
	
	/**
	* @param 	String ordemSQL
	* @return 	Resource Consulta Banco
	*/
	public function executaLista($ordemSQL='')
	{
		$this->stDebug = $this->montaLista();
		if (strlen($ordemSQL))
		{
			$this->stDebug = $this->montaOrderBySQL($this->stDebug, $ordemSQL);
		}
	
		$this->roConsulta = $this->obConexao->executaSQL($this->stDebug);
		if ($this->obConexao->getErro() > 0)
		{
			$this->stDebug = $this->obConexao->getMsg();
			$this->roConsulta = null;
		}
		if (mysql_num_rows($this->roConsulta))
		{
			$this->inRegSelecionados = mysql_num_rows($this->roConsulta);
		}
		else
		{
			$this->inRegSelecionados = 0;
		}
		return $this->roConsulta;
	}
	
	
	/**
	* @param 	String Consulta SQL
	* @return 	Resource Consulta Banco
	*/
	function executaSQL($stSQL)
	{
		if (strlen($stSQL))
		{	
			$this->stDebug = $stSQL;
			$this->roConsulta = $this->obConexao->executaSQL($this->stDebug);	
			if ($this->obConexao->getErro() > 0)
			{
				$this->stDebug = $this->obConexao->getMsg();
				$this->roConsulta = null;
			}
			if (@mysql_num_rows($this->roConsulta))
			{
				$this->inRegSelecionados = mysql_num_rows($this->roConsulta);
			}
			else
			{
				$this->inRegSelecionados = 0;
			}
			if (@mysql_affected_rows($this->roConsulta))
			{
				$this->inRegAfetados = mysql_affected_rows($this->roConsulta);
			}
			else
			{
				$this->inRegAfetados = 0;
			}
		}
		else
		{	
			$this->roConsulta = false;	
		}
		return $this->roConsulta;
	}
	
	// Metodos de Utilidade Geral
	
	public function montaOrderBySQL($stSQL, $stOrder='')
	{
		$arMinus = array('select', 'from', 'where', ' as ', 'order');
		$arMaius = array('SELECT', 'FROM', 'WHERE', ' AS ', 'ORDER');
		$stSQL = str_replace($arMinus, $arMaius, $stSQL);
		// retira o ORDER
		if (strrpos($stSQL, 'ORDER'))
		{
			$stSQL = substr($stSQL, 0, strrpos($stSQL, 'ORDER'));
		}
		if (strlen($stOrder) > 0)
		{
			$stOrder = htmlentities($stOrder, ENT_QUOTES);
			$stAscDesc = substr($stOrder, -1, 1);
			if ($stAscDesc == '1' || $stAscDesc == '0')
			{
				$stCampoOrdem = substr($stOrder, 0, -1);
			}
			else
			{
				$stCampoOrdem = $stOrder;
			}
	
			if ($stAscDesc == '1')
			{
				$stAscDesc = 'DESC';
			}
			else
			{
				$stAscDesc = 'ASC';
			}
			$stOrderSQL = ' ORDER BY ' . $stCampoOrdem . ' ' . $stAscDesc;
			$stSQL .= $stOrderSQL;
		}
		return $stSQL;
	}
	
	public function preparaSQL($stSql)
	{
		$stSql = str_replace(array("\n", "\t", "\r"), array(" ", "", " "), $stSql);
		return $stSql;
	}
}
?>
