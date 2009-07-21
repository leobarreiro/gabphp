<?php
/**
 	* Framework GabPhp
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gab
    * 
    * Classe de Mapeamento para Tabela gba_acao
    * Data de Criação: 21/06/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package GabPhp
    * @subpackage mapeamento
    *     
    * $Id: MPAcao.class.php 51 2008-07-05 06:19:15Z leobba $
    *     
    * Casos de uso: 
*/

include_once( GBA_PATH_CLA_BDA . 'Persistente.class.php' );

class MPAcao extends Persistente {
	
	public function MPAcao()
	{
		parent::Persistente();
		$this->setTabela( GBA_BD_TACAO );
		$this->recuperaCamposTabela();	
	}
	
	public function montaListaAcaoPorFuncionalidade($inCodFuncionalidade, $stOrdem)
	{
		if ($inCodFuncionalidade > 0)
		{
			$stSQL = "SELECT * FROM gba_acao WHERE codfuncionalidade = " . $inCodFuncionalidade . " ORDER BY " . $stOrdem . " ";
		}
		else
		{
			$stSQL = false;
		}
		return $stSQL;
	}
	
	/**
	* @param 	integer CodFuncionalidade
	* @return 	resource Consulta Banco
	* */
	public function executaListaAcaoPorFuncionalidade($inCodFuncionalidade, $stOrdem='ordem')
	{
		$roRetorno = false;
		$stSQL = $this->montaListaAcaoPorFuncionalidade((integer) $inCodFuncionalidade, $stOrdem);
		if ($stSQL)
		{
			$this->roConsulta = $this->obConexao->executaSQL( $stSQL );
			$roRetorno = $this->roConsulta;
		}
		return $roRetorno;
	}
	
	public function montaListaAcaoGeral($arOpcoes, $stOrdem)
	{
		$stSql = "
		SELECT 
			ac.codacao AS codigo, 
			ac.descricao AS descricao, 
			ac.programa AS prog, 
			ac.ordem AS ordem, 
			fu.descricao AS funcionalidade, 
			mo.descricao AS modulo 
		FROM 
			gba_acao AS ac 
			INNER JOIN 
			gba_funcionalidade AS fu ON 
			fu.codfuncionalidade = ac.codfuncionalidade 
			INNER JOIN 
			gba_modulo AS mo ON 
			mo.codmodulo = fu.codmodulo 
		WHERE 
			TRUE  ";
			
		if (isset($arOpcoes['codmodulo']) && ((int) $arOpcoes['codmodulo']) > 0)
		{
			$stSql .= " AND mo.codmodulo = " . (int) $arOpcoes['codmodulo'] . " ";
		}
			
		if (isset($arOpcoes['codfuncionalidade']) && ((int) $arOpcoes['codfuncionalidade']) > 0)
		{
			$stSql .= " AND fu.codfuncionalidade = " . (int) $arOpcoes['codfuncionalidade'] . " ";
		}
		
		if (isset($arOpcoes['descricao']) && strlen($arOpcoes['descricao']) > 0)
		{
			$stSql .= " AND ac.descricao LIKE '%" . $arOpcoes['descricao'] . "%' ";
		}
		
		$stSql .= " ORDER BY " . $stOrdem . " ";
		return $stSql;
	}
	
	public function executaListaAcaoGeral($arOpcoes=array(), $stOrdem='ac.codacao, ac.descricao, fu.descricao, mo.descricao')
	{
		$roRetorno = false;
		$stSQL = $this->montaListaAcaoGeral($arOpcoes, $stOrdem);
		if ($stSQL)
		{
			$this->roConsulta = $this->obConexao->executaSQL( $stSQL );
			$roRetorno = $this->roConsulta;
		}
		return $roRetorno;
	}

}
?>