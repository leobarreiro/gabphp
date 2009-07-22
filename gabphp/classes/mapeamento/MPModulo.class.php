<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Classe de Mapeamento de Tabela: gba_modulo
    * Data de Criacao: 21/06/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: MPModulo.class.php 51 2008-07-05 06:19:15Z leobba $
    *     
    * Casos de uso : 
*/
include_once( GBA_PATH_CLA_BDA . 'Persistente.class.php' );

class MPModulo extends Persistente {
	
	public function MPModulo()
	{
		parent::Persistente();
		$this->setTabela( GBA_BD_TMODU );
		$this->recuperaCamposTabela();	
	}
	/**
	* @todo implementar consulta para retornar os modulos disponiveis para o usuario
	* */
	public function montaModulosUsuario($inCodUsuario)
	{
		$stSQL = " SELECT " . $this->getTabela() . "  WHERE codusuario = " . $inCodUsuario . " ";
		return $stSQL;
	}
	
	/**
	 * @params 	integer inCodUsuario 
	 * @desc 	Retorna todos os Modulos permitidos para determinado Usuario
	 * @return 	Resource Lista de Modulos
	*/
	public function modulosUsuario($inCodUsuario)
	{
		$boRetorno = false;
		if ($inCodUsuario > 0)
		{
			$stSQL = $this->montaModulosUsuario($inCodUsuario);
			$rsModulos = $this->obConexao->executaSQL($stSQL);
		}
		return $boRetorno;
	}
	
	public function montaRecuperaPorDiretorio($stDiretorio)
	{
		$stSQL = "SELECT * FROM `" . $this->getTabela() . "` WHERE diretorio = '" . $stDiretorio . "' ";
		return $stSQL;
	}
	
	/**
	* @desc 	Retorna os dados do Modulo de acordo com o diretorio passado por parametro
	* @param 	String Diretorio do Modulo
	* @return 	Resource Consulta do Banco
	* 
	* */
	public function recuperaPorDiretorio($stDiretorio)
	{
		$stSQL = $this->montaRecuperaPorDiretorio($stDiretorio);
		$this->executaSQL($stSQL);
	}
	
	public function montaListaModuloGeral($arOpcoes, $stOrdem)
	{
		$stSql = "
		SELECT 
			codmodulo AS codigo, 
			descricao, 
			diretorio 
		FROM 
			gba_modulo 
		WHERE 
			TRUE  ";
			
		if (isset($arOpcoes['descricao']) && strlen($arOpcoes['descricao']) > 0)
		{
			$stSql .= " AND descricao LIKE '%" . $arOpcoes['descricao'] . "%' ";
		}
		
		$stSql .= " ORDER BY " . $stOrdem . " ";
		return $stSql;
	}
	
	
	public function executaListaModuloGeral($arOpcoes, $stOrdem='descricao ASC')
	{
		$roRetorno = false;
		$stSQL = $this->montaListaModuloGeral($arOpcoes, $stOrdem);
		if ($stSQL)
		{
			$this->roConsulta = $this->obConexao->executaSQL( $stSQL );
			$roRetorno = $this->roConsulta;
		}
		return $roRetorno;
	}
}
?>