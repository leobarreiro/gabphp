<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Classe de Conexao com Base de Dados
    * Data de Criacao: 05/01/2008
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: $
    * $Author: $
    * 
    * Casos de uso : 
*/

class Conexao {

	public $stHost;
	public $stUsuario;
	public $stSenha;
	public $stBanco;
	public $idConexao;
	public $stMsg;
	public $inErro;
	public $roConsulta;
	
	public function setHost($stHost)
	{
		$this->stHost = (string) $stHost;
	}
	
	public function setUsuario($stUsuario)
	{
		$this->stUsuario = (string) $stUsuario;
	}
	
	public function setSenha($stSenha)
	{
		$this->stSenha = (string) $stSenha;
	}
	
	public function setBanco($stBanco)
	{
		$this->stBanco = (string) $stBanco;
	}
	
	public function setMsg($stMsg)
	{
		$this->stMsg = (string) $stMsg;
	}
	
	public function setErro($integer)
	{
		$this->inErro = (integer) $integer;
	}
	
	/* Permite definir uma conexao ja existente */
	public function setConexao($idConexao)
	{
		$this->idConexao = $idConexao;
	}
	
	public function getHost()
	{
		return $this->stHost;
	}
	
	public function getUsuario()
	{
		return $this->stUsuario;
	}
	
	public function getSenha()
	{
		return $this->stSenha;
	}
	
	public function getBanco()
	{
		return $this->stBanco;
	}
	
	public function getMsg()
	{
		return $this->stMsg;
	}
	
	public function getErro()
	{
		return $this->inErro;
	}
	
	public function getConexao()
	{
		return $this->idConexao;
	}
	
	public function Conexao($stHost=null, $stUsuario=null, $stSenha=null, $stBanco=null)
	{	
		if (strlen($stHost))
		{
			$this->setHost($stHost);
		}
		if (strlen($stUsuario))
		{
			$this->setUsuario($stUsuario);
		}
		if (strlen($stSenha))
		{
			$this->setSenha($stSenha);
		}
		if (strlen($stBanco))
		{
			$this->setBanco($stBanco);
		}
		if ($this->getHost() && $this->getUsuario() && $this->getSenha())
		{
			$this->conecta();
		}
		if ($this->getBanco())
		{
			$this->selecionaBanco();
		}	
		if (is_resource($this->idConexao))
		{
			if (mysql_error($this->getConexao()))
			{
				$this->setMsg(mysql_error($this->getConexao()));
				$this->setErro(2);
			}
			else
			{
				$this->setMsg('Conectado corretamente.');
				$this->setErro(0);
			}		
		}
		else
		{
			$this->setConexao(null);
			$this->setMsg('Nao ocorreu a Conexao');
			$this->setErro(1);
		}
	}
	
	public function conecta()
	{
		$this->idConexao = mysql_connect($this->getHost(), $this->getUsuario(), $this->getSenha());
		return $this->idConexao;
	}
	
	public function selecionaBanco()
	{
		mysql_select_db($this->getBanco());
	}
	
	/**
	 * @name 		executaSQL
	 * @desc 		Executa uma expressao SQL no banco
	 * @param 		String stSQL
	 * @return 		Resource 
	* */
	public function executaSQL($sql)
	{
		if (is_resource($this->idConexao))
		{
			$this->roConsulta = mysql_query($sql, $this->idConexao);
			if (mysql_error($this->getConexao()))
			{
				$this->setMsg( mysql_error($this->getConexao()) );
				$this->setErro( mysql_errno($this->getConexao()) );
				return false;
			}
			else
			{
				$this->setMsg('Sem erro');
				$this->setErro(0);
				return $this->roConsulta;
			}		
		}
		else
		{
			$this->setMsg('Sem conexao estabelecida');
			$this->setErro(1);
			return false;
		}
	}

}
?>