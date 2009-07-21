<?php
/**
 	* Framework GabPhp
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gab
    * 
    * Classe de Mapeamento para Tabela gba_funcionalidade
    * Data de Criacao: 21/06/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package GabPhp
    * @subpackage mapeamento
    *     
    * $Id: MPFuncionalidade.class.php 51 2008-07-05 06:19:15Z leobba $
    *     
    * Casos de uso: 
*/

include_once( GBA_PATH_CLA_BDA . 'Persistente.class.php' );

class MPFuncionalidade extends Persistente {

	public function MPFuncionalidade()
	{
		parent::Persistente();
		$this->setTabela( GBA_BD_TFUNC );
		$this->recuperaCamposTabela();	
	}
	
	public function montaListaFuncionalidadePorModulo($inCodModulo)
	{
		if ($inCodModulo > 0)
		{
			$stSQL = "SELECT * FROM gba_funcionalidade WHERE codmodulo = " . $inCodModulo . " ORDER BY descricao ASC";
		}
		else
		{
			$stSQL = "SELECT * FROM gba_funcionalidade ORDER BY descricao ASC";
		}
		return $stSQL;
	}
	
	/**
	* @param 	integer CodModulo
	* @return 	resource Consulta Banco
	* */
	public function executaListaFuncionalidadePorModulo($inCodModulo)
	{
		$roRetorno = false;
		$stSQL = $this->montaListaFuncionalidadePorModulo((integer) $inCodModulo);
		if ($stSQL)
		{
			$this->roConsulta = $this->obConexao->executaSQL( $stSQL );
			$roRetorno = $this->roConsulta;
		}
		return $roRetorno;
	}

	public function montaListaFuncionalidadeGeral($arOpcoes, $stOrdem)
	{
		$stSql = "
		SELECT 
			fu.codfuncionalidade AS codigo, 
			fu.descricao AS descricao, 
			fu.diretorio AS diretorio, 
			fu.programa AS prog, 
			mo.descricao AS modulo 
		FROM 
			gba_funcionalidade AS fu 
			INNER JOIN 
			gba_modulo AS mo ON 
			mo.codmodulo = fu.codmodulo 
		WHERE
			TRUE ";
		
		if (isset($arOpcoes['codmodulo']) && ((int) $arOpcoes['codmodulo'] > 0))
		{
			$stSql .= " AND mo.codmodulo = " . $arOpcoes['codmodulo'] . " ";
		}
		
		if (isset($arOpcoes['descricao']) && strlen(strip_tags($arOpcoes['descricao'])) > 0)
		{
			$stSql .= " AND fu.descricao LIKE '" . strip_tags($arOpcoes['descricao']) . "' ";
		}
		$stSql .= " ORDER BY " . $stOrdem . " ";
		return $stSql;
	}
	
	public function executaListaFuncionalidadeGeral($arOpcoes=array(), $stOrdem='fu.descricao, fu.codfuncionalidade, mo.descricao')
	{
		$roRetorno = false;
		$stSQL = $this->montaListaFuncionalidadeGeral($arOpcoes, $stOrdem);
		if ($stSQL)
		{
			$this->roConsulta = $this->obConexao->executaSQL( $stSQL );
			$roRetorno = $this->roConsulta;
		}
		return $roRetorno;
	}
}
?>