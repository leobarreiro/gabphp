<?php

class Conexao {

var $stHost;
var $stUsuario;
var $stSenha;
var $stBanco;
var $idConexao;
var $stMsg;
var $inErro;
var $roConsulta;

function setHost($stHost) { $this->stHost = (string) $stHost; }
function setUsuario($stUsuario) { $this->stUsuario = (string) $stUsuario; }
function setSenha($stSenha) { $this->stSenha = (string) $stSenha; }
function setBanco($stBanco) { $this->stBanco = (string) $stBanco; }
function setMsg($stMsg) { $this->stMsg = (string) $stMsg; }
function setErro($integer) { $this->inErro = (integer) $integer; }
function setConexao($idConexao) { $this->idConexao = $idConexao; } /* Permite definir uma conexão já existente */

function getHost() { return $this->stHost; }
function getUsuario() { return $this->stUsuario; }
function getSenha() { return $this->stSenha; }
function getBanco() { return $this->stBanco; }
function getMsg() { return $this->stMsg; }
function getErro() { return $this->inErro; }
function getConexao() {return $this->idConexao; }

function Conexao($stHost=null, $stUsuario=null, $stSenha=null, $stBanco=null) {
	
	if (strlen($stHost)) { $this->setHost($stHost); }
	if (strlen($stUsuario)) { $this->setUsuario($stUsuario); }
	if (strlen($stSenha)) { $this->setSenha($stSenha); }
	if (strlen($stBanco)) { $this->setBanco($stBanco); }
	
	if ($this->getHost() && $this->getUsuario() && $this->getSenha()) {
		$this->conecta();
	}
	
	if ($this->getBanco()) {
		$this->selecionaBanco();
	}	
	
	if (is_resource($this->idConexao)) {		
		if(mysql_error($this->getConexao())) {
			$this->setMsg(mysql_error($this->getConexao()));
			$this->setErro(2);
		}
		else {
			$this->setMsg('Conectado corretamente.');
			$this->setErro(0);
		}		
	}
	else {
		$this->setConexao(null);
		$this->setMsg('Não ocorreu a Conexão');
		$this->setErro(1);		
	}

}

function conecta() {
	$this->idConexao = mysql_connect($this->getHost(), $this->getUsuario(), $this->getSenha());
}

function selecionaBanco() {
	mysql_select_db($this->getBanco());
}

/**
 * @name 		executaSQL
 * @desc 		Executa uma expressao SQL no banco
 * @param 		String stSQL
 * @return 		Resource 
* */

function executaSQL($sql) {
	if (is_resource($this->idConexao)) {		
		$this->roConsulta = mysql_query($sql, $this->idConexao);		
		if (mysql_error($this->getConexao())) {
			$this->setMsg( mysql_error($this->getConexao()) );
			$this->setErro( mysql_errno($this->getConexao()) );
			return false;
		} else {
			$this->setMsg('Sem erro');
			$this->setErro(0);
			return $this->roConsulta;
		}		
	} else {		
		$this->setMsg('Sem conexão estabelecida');
		$this->setErro(1);
		return false;
	}
	
}


}
?>