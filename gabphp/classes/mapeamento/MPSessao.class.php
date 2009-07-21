<?php
/*
* MPSessao.class.php
* 06/01/2008
* 
* 
* $Id : $
*/
include_once( GBA_PATH_CLA_BDA . 'Persistente.class.php' );

class MPSessao extends Persistente {

function MPSessao() {
	parent::Persistente();
	$this->setTabela( GBA_BD_TSESS );
	$this->recuperaCamposTabela();	
}

function montaEncerraSessoesUsuario($inCodUsuario) {
	$stSQL = "	UPDATE " . $this->getTabela() . " SET ativa = '0' WHERE codusuario = " . $inCodUsuario . " ";
	return $stSQL;
}

/**
 * @params 	integer inCodUsuario 
 * @desc 	Encerra todas as Sessões do Usuário passado como parâmetro
 * @return 	boolean Sucesso
*/
function encerraSessoesUsuario($inCodUsuario) {
	$boRetorno = false;
	if (is_integer($inCodUsuario) && $inCodUsuario > 0) {
		$stSQL = $this->montaEncerraSessoesUsuario($inCodUsuario);
		$rsEncerra = $this->obConexao->executaSQL($stSQL);
		if ($rsEncerra !== false) {
			$boRetorno = true;
		}
	}
	return $boRetorno;
}
	
}

?>