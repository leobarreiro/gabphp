<?
// bdBackUpSwBrasil.class.php
// 23/10/2006
// Ferramentas para backup automático de dados e arquivos
// Dados em MySQL
// Arquivos via Ftp

class bdBackUpSwBrasil {
	var $hostDb;
	var $dataBase;
	var $userDb;
	var $passDb;
	var $versionDb;
	var $conexaoBanco;
	var $conectado;
	var $bancoSelecionado;
	var $tablesInfo;
	var $default_charset;

	function bdBackUpSwBrasil ($hostDb, $userDb, $passDb, $dataBase) {
		$this->hostDb = $hostDb;
		$this->dataBase = $dataBase;
		$this->userDb = $userDb;
		$this->passDb = $passDb;
		$this->conexaoBanco = @mysql_connect($hostDb, $userDb, $passDb);
		if (is_resource($this->conexaoBanco)) {
			$this->bancoSelecionado = @mysql_select_db($dataBase);
			if ($this->bancoSelecionado) {
				$this->conectado = true;
				$this->default_charset = 'latin1';
			} else {
				$this->conectado = false;
				$this->default_charset = null;
			}
		} else {
			$this->bancoSelecionado = false;
			$this->conectado = false;
			$this->default_charset = null;
		}
	}
	
	function RetornaConectado() {
		return $this->conectado;
	}
	
	function ListaTabelas() {
		if ($this->conectado) {
			$this->tablesInfo = array();
			$sql = "SHOW TABLE STATUS FROM `" . $this->dataBase . "` ";
			$query = mysql_query($sql, $this->conexaoBanco);
			while ($linhaReg = mysql_fetch_assoc($query)) {				
				$this->tablesInfo[] = array('NAME'=>$linhaReg['Name'], 
										'ENGINE'=>$linhaReg['Engine'], 
										'DEFAULT_CHARSET'=>$this->default_charset, 
										'CREATE_OPTIONS'=>$linhaReg['Create_options'], 
										'COMMENT'=>$linhaReg['Comment'] );
			}
		}
		else {
			$this->tablesInfo = null;
		}
	}
	
	function RetornaListaTabelas() {
		return $this->tablesInfo;
	}
}
?>