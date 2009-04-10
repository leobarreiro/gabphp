<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Classe de Tabela em PDF
    * Data de Criação: 27/11/2007
    * @author Leopoldo Braga Barreiro
    *     
    * @package GBAPHP
    * @subpackage
    *     
    * $Id: $
    *     
    * Casos de uso : 
*/

/**
* TODO: Fazer os metodos set e get para formatacao de campos!! 
* */

class TabelaPDF
{
	var $stOrientacao;
	var $arCabecalho;
	var $arCamposTabela;
	var $rsDados;
	var $inNumeroColunas;
	var $inNumeroLinhas;
	
	var $stSumario;
	var $stFonteCabecalho;
	var $stEstiloFonteCabecalho;
	var $inAlturaFonteCabecalho;
	var $stAlinhamentoCabecalho;	
	var $inAlturaCelulaCabecalho;
	var $stBordaCabecalho;
	
	var $stFonteCampo;
	var $stEstiloFonteCampo;
	var $inAlturaFonteCampo;
	var $stAlinhamentoCampo;
	var $inAlturaCelulaCampo;
	var $stBordaCampo;
	
	
	public function setCabecalho($arValor)
	{ 
		$this->arCabecalho = $arValor;
		$this->inNumeroColunas = count($arValor);
	}
	
	public function setCamposTabela($arValor)
	{
		$this->arCamposTabela = $arValor;
	}
	
	public function setDados($rsValor)
	{ 
		$this->rsDados = $rsValor;
		$this->inNumeroLinhas = count($rsValor);
	}
	
	public function setOrientacao($stValor)
	{
		$this->stOrientacao = $stValor;
	}
	
	public function setFonteCabecalho($string)
	{
		$this->stFonteCabecalho = $string;
	}
	
	public function setEstiloFonteCabecalho($string)
	{
		$this->stEstiloFonteCabecalho = $string;
	}
	
	public function setAlturaFonteCabecalho($integer)
	{
		$this->inAlturaFonteCabecalho = $integer;
	}
	
	public function setAlinhamentoCabecalho($string)
	{
		$this->stAlinhamentoCabecalho = $string;
	}
	
	public function setFonteCampo($string)
	{
		$this->stFonteCampo = $string;
	}
	
	public function setEstiloFonteCampo($string)
	{
		$this->stEstiloFonteCampo = $string;
	}
	
	public function setAlturaFonteCampo($integer)
	{
		$this->inAlturaFonteCampo = $integer;
	}
	
	public function setAlinhamentoCampo($string)
	{
		$this->stAlinhamentoCampo = $string;
	}
	
	public function setNumeroColunas($inValor)
	{
		$this->inNumeroColunas = $inValor;
	}
	
	public function setNumeroLinhas($inValor)
	{
		$this->inNumeroLinhas = $inValor;
	}
	
	public function setSumario($stValor)
	{
		$this->stSumario = $stValor;
	}	
	
	public function getCabecalho()
	{
		return $this->arCabecalho;
	}
	
	public function getCamposTabela()
	{
		$this->arCamposTabela;
	}
	
	public function getDados()
	{
		return $this->rsDados;
	}
	
	public function getOrientacao()
	{
		return $this->stOrientacao;
	}
	
	public function getFonteCabecalho()
	{
		return $this->stFonteCabecalho;
	}
	
	public function getEstiloFonteCabecalho()
	{
		return $this->stEstiloFonteCabecalho;
	}
	
	public function getAlturaFonteCabecalho()
	{
		return $this->inAlturaFonteCabecalho;
	}
	
	public function getAlinhamentoCabecalho()
	{
		return $this->stAlinhamentoCabecalho;
	}
	
	public function getFonteCampo()
	{
		return $this->stFonteCampo;
	}
	
	public function getEstiloFonteCampo()
	{
		return $this->stEstiloFonteCampo;
	}
	
	public function getAlturaFonteCampo()
	{
		return $this->inAlturaFonteCampo;
	}
	
	public function getAlinhamentoCampo()
	{
		return $this->stAlinhamentoCampo;
	}
	
	public function getNumeroColunas()
	{
		return $this->inNumeroColunas;
	}
	
	public function getNumeroLinhas()
	{
		return $this->inNumeroLinhas;
	}
	
	public function getSumario()
	{
		return $this->stSumario;
	}
	
	public function addCabecalho($nome, $descricao, $espessura)
	{
		$obCampoCabecalho = new CampoTabelaPDF;
		$obCampoCabecalho->setAlinhamento($this->getAlinhamentoCabecalho());
		$obCampoCabecalho->setAlturaCelula($this->inAlturaCelulaCabecalho)
		$obCampoCabecalho->setFonte($this->getFonteCabecalho());
		$obCampoCabecalho->setAlturaFonte($this->getAlturaFonteCabecalho());
		$obCampoCabecalho->setEstiloFonte($this->getEstiloFonteCabecalho());
		$obCampoCabecalho->setBorda($this->stBordaCabecalho);
		$obCampoCabecalho->setNomeCampo($nome);
		$obCampoCabecalho->setDescricaoCampo($descricao);
		$obCampoCabecalho->setEspessuraCelula($espessura);
		$arCabecalho = $this->arCabecalho;
		$arCabecalho[] = $obCampoCabecalho; 
		$this->arCabecalho = $arCabecalho;
		$this->inNumeroColunas = count($this->arCabecalho);
	}
	
	public function addCampo($nome, $espessura)
	{
		$obCampoTabela = new CampoTabelaPDF;
		$obCampoTabela->setAlinhamento($this->getAlinhamentoCampo());
		$obCampoTabela->setAlturaCelula($this->inAlturaCelulaCampo);
		$obCampoTabela->setFonte($this->getFonteCampo());
		$obCampoTabela->setAlturaFonte($this->getAlturaFonteCampo());
		$obCampoTabela->setEstiloFonte($this->getEstiloFonteCampo());
		$obCampoTabela->setBorda($this->stBordaCampo);
		$obCampoTabela->setNomeCampo($nome);
		$obCampoTabela->setEspessuraCelula($espessura);
		$arCampos = $this->arCamposTabela;
		$arCampos[] = $obCampoTabela; 
		$this->arCamposTabela = $arCampos;
		$this->inNumeroLinhas = count($this->arCamposTabela);
	}
	
	/**
	 * Método Construtor
	 * @param $stOrientacao
	 * @return unknown_type
	 */
	public function TabelaPDF($stOrientacao='P')
	{
		$this->stOrientacao = $stOrientacao;
		$this->arCabecalho = array();
		$this->arCamposTabela = array();
		$this->rsDados = array();
		$this->inNumeroColunas = 0;
		$this->inNumeroLinhas = 0;
		$this->stFonteCabecalho = 'Arial';
		$this->stEstiloFonteCabecalho = '';
		$this->inAlturaFonteCabecalho = 11;
		$this->stAlinhamentoCabecalho = 'L';
		$this->inAlturaCelulaCabecalho = 7;
		$this->stBordaCabecalho = 'LTRB';
		$this->stAlinhamentoCabecalho = 'C';
		$this->stFonteCampo = 'Arial';
		$this->stEstiloFonteCampo = '';
		$this->inAlturaFonteCampo = 10;
		$this->stAlinhamentoCampo = 'L';
		$this->inAlturaCelulaCampo = 5;
		$this->stBordaCampo = 'LTRB';		
	}
	
	public function geraPDF(&$obListaPDF)
	{	
		// Sumario	
		if ( strlen($this->getSumario()) > 0 )
		{
			$obListaPDF->ln();
			$obCampoSumario = new CampoTabelaPDF;	
			$obCampoSumario->setAlinhamento('C');
			$obCampoSumario->setAlturaCelula(10);
			$obCampoSumario->setAlturaFonte(10);
			$obCampoSumario->setBorda('0');
			$obCampoSumario->setNomeCampo('sumario');
			$obCampoSumario->setDescricaoCampo($this->getSumario());
			if ($this->getOrientacao() == 'L')
			{
				$obCampoSumario->setEspessuraCelula(270);
			}
			else
			{
				$obCampoSumario->setEspessuraCelula(190);
			}
			$obCampoSumario->geraCelulaPDF(&$obListaPDF);
		}
		// Cabeçalho		
		$obListaPDF->ln();		
		foreach ($this->arCabecalho as $obCampoCabecalho)
		{
			$obCampoCabecalho->geraCelulaPDF(&$obListaPDF);
		}
		// Conteúdo
		$rsDados = $this->rsDados;		
		foreach ($rsDados as $registro)
		{
			$obListaPDF->ln();
			foreach ($this->arCamposTabela as $obCampo)
			{
				$nomeCampo = $obCampo->getNomeCampo();
				$obCampo->setDescricaoCampo($registro[$nomeCampo]);			
				$obCampo->geraCelulaPDF(&$obListaPDF);
			}			
		}	
	}
}
?>