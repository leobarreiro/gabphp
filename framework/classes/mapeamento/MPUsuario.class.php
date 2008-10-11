<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Classe de Mapeamento para Tabela gba_usuario
    * Data de Criaчуo: 18/01/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: $
    *     
    * Casos de uso : 
*/

include_once( GBA_PATH_CLA_BDA . 'Persistente.class.php' );

class MPUsuario extends Persistente {

function MPUsuario() {
	parent::Persistente();
	$this->setTabela( GBA_BD_TUSUA );
	$this->recuperaCamposTabela();	
}

function montaLista() {
	$stSQL = "	SELECT 
				usu.codusuario, 
				usu.nomecompleto, 
				usu.nomeusuario, 
				usu.email, 
				CASE usu.ativo
					WHEN '1' THEN 'sim'  
					WHEN '2' THEN 'nao'  
				END AS atv, 
				ad.codusuario AS codadmin, 
				ad.nomecompleto AS nomeadmin, 
				DATE_FORMAT(MAX(sess.datainicio), '%d/%m/%y') AS dtult, 
				MAX(sess.datainicio) AS ultimo_acesso  
			FROM 
				`" . $this->getTabela() . "` AS usu INNER JOIN 
				`" . GBA_BD_TEMPR . "` AS empr ON 
				empr.codempresa = usu.codempresa INNER JOIN 
				`" . $this->getTabela() . "` ad ON 
				ad.codusuario = usu.codadm LEFT JOIN 
				`" . GBA_BD_TSESS . "` sess ON 
				usu.codusuario = sess.codusuario 
			WHERE 1 
			GROUP BY usu.codusuario 
			ORDER BY usu.nomecompleto ASC ";
	
	return $stSQL;	
}

/**
* @param 	Array arParams: Parametros da Consulta de Lista Especial
* @return 	Database Resource: roConsulta
* */
function executaListaEspecial( $arParams=array() ) {
	
	$stSQL = $this->montaListaEspecial( $arParams );
	$this->roConsulta = $this->obConexao->executaSQL( $stSQL );
	return $this->roConsulta;
	
}


function montaListaEspecial( $arParams=array() ) {
	
	$stSQL = "	SELECT 
				usu.codusuario, 
				usu.nomecompleto, 
				usu.nomeusuario, 
				usu.email, 
				CASE usu.ativo
					WHEN '1' THEN 'sim'  
					WHEN '2' THEN 'nao'  
				END AS atv, 
				ad.codusuario AS codadmin, 
				ad.nomecompleto AS nomeadmin, 
				DATE_FORMAT(MAX(sess.datainicio), '%d/%m/%y') AS dtult, 
				MAX(sess.datainicio) AS ultimo_acesso  
			FROM 
				`" . $this->getTabela() . "` AS usu INNER JOIN 
				`" . GBA_BD_TEMPR . "` AS empr ON 
				empr.codempresa = usu.codempresa INNER JOIN 
				`" . $this->getTabela() . "` ad ON 
				ad.codusuario = usu.codadm LEFT JOIN 
				`" . GBA_BD_TSESS . "` sess ON 
				usu.codusuario = sess.codusuario 
			WHERE empr.codempresa = " . $_SESSION['sessao']['codempresa'] . " "; 

	if (isset($arParams['codadm']) && strlen($arParams['codadm'])) {
		$stSQL .= "	AND usu.codadm IN ( " . $arParams['codadm'] . " ) ";
	}
	if (isset($arParams['administrador']) && strlen($arParams['administrador'])) {
		$stSQL .= "	AND usu.administrador = " . $arParams['administrador'] . " ";
	}
	if (isset($arParams['agendaempresa']) && strlen($arParams['agendaempresa'])) {
		$stSQL .= "	AND usu.agendaempresa = " . $arParams['agendaempresa'] . " ";
	}

	$stSQL .= "	GROUP BY usu.codusuario 
				ORDER BY usu.nomecompleto ASC ";
	
	return $stSQL;
		
}

function executaListaFuncionariosGerente( $arParams=array() ) {
	$stSQL = $this->montaListaFuncionariosGerente( $arParams );
	$this->roConsulta = $this->obConexao->executaSQL( $stSQL );
	return $this->roConsulta;
}


function montaListaFuncionariosGerente( $arParams=array() ) {

	// Listar codusuario, nomecompleto, email e ativo 
	// de todos os codadm que sejam subordinados do usuario
	
	// Subordinados Indiretos
	
	$stSQL = "	SELECT 
				codusuario, 
				nomecompleto, 
				nomeusuario, 
				email, 
				ativo 
			FROM 
				`" . $this->getTabela() . "` 
			WHERE codadm IN (	SELECT codusuario 
								FROM `" . $this->getTabela() . "` 
								WHERE codadm = " . $_SESSION['sessao']['codusuario'] . " ) ";

	if (isset($arParams['administrador']) && strlen($arParams['administrador'])) {
		$stSQL .= "	AND administrador = " . $arParams['administrador'] . " ";
	}
	if (isset($arParams['agendaempresa']) && strlen($arParams['agendaempresa'])) {
		$stSQL .= "	AND agendaempresa = " . $arParams['agendaempresa'] . " ";
	}

	// Subordinados Diretos
	
	$stSQL .= "	UNION ALL 
			SELECT 
				codusuario, 
				nomecompleto, 
				nomeusuario, 
				email, 
				ativo 
			FROM 
				`" . $this->getTabela() . "` 
			WHERE codadm = " . $_SESSION['sessao']['codusuario'] . " ";
	
	if (isset($arParams['administrador']) && strlen($arParams['administrador'])) {
		$stSQL .= "	AND administrador = " . $arParams['administrador'] . " ";
	}
	if (isset($arParams['agendaempresa']) && strlen($arParams['agendaempresa'])) {
		$stSQL .= "	AND agendaempresa = " . $arParams['agendaempresa'] . " ";
	}
	
	return $stSQL;
}
	
}
?>