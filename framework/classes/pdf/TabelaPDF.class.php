<?php
// 27/11/2007
/**
* TODO: Fazer os metodos set e get para formatacao de campos!! 
* */

class TabelaPDF {
	
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
	
	
	function setCabecalho($arValor) { 
		$this->arCabecalho = $arValor;
		$this->inNumeroColunas = count($arValor);
	}
	
	function setCamposTabela($arValor) { $this->arCamposTabela = $arValor; }
	
	function setDados($rsValor) { 
		$this->rsDados = $rsValor;
		$this->inNumeroLinhas = count($rsValor);
	}
	
	function setOrientacao($stValor) { $this->stOrientacao = $stValor; }
	
	function setFonteCabecalho($string) { $this->stFonteCabecalho = $string; }
	
	function setEstiloFonteCabecalho($string) { $this->stEstiloFonteCabecalho = $string; }
	
	function setAlturaFonteCabecalho($integer) { $this->inAlturaFonteCabecalho = $integer; }
	
	function setAlinhamentoCabecalho($string) { $this->stAlinhamentoCabecalho = $string; }
	
	function setFonteCampo($string) { $this->stFonteCampo = $string; }
	
	function setEstiloFonteCampo($string) { $this->stEstiloFonteCampo = $string; }
	
	function setAlturaFonteCampo($integer) { $this->inAlturaFonteCampo = $integer; }
	
	function setAlinhamentoCampo($string) { $this->stAlinhamentoCampo = $string; }
	
	function setNumeroColunas($inValor) { $this->inNumeroColunas = $inValor; }
	
	function setNumeroLinhas($inValor) { $this->inNumeroLinhas = $inValor; }
	
	function setSumario($stValor) { $this->stSumario = $stValor; }	
	
	function getCabecalho() { return $this->arCabecalho; }
	
	function getCamposTabela() { $this->arCamposTabela; }
	
	function getDados() { return $this->rsDados; }
	
	function getOrientacao() { return $this->stOrientacao; }
	
	function getFonteCabecalho() { return $this->stFonteCabecalho; }
	
	function getEstiloFonteCabecalho() { return $this->stEstiloFonteCabecalho; }
	
	function getAlturaFonteCabecalho() { return $this->inAlturaFonteCabecalho; }
	
	function getAlinhamentoCabecalho() { return $this->stAlinhamentoCabecalho; }
	
	function getFonteCampo() { return $this->stFonteCampo; }
	
	function getEstiloFonteCampo() { return $this->stEstiloFonteCampo; }
	
	function getAlturaFonteCampo() { return $this->inAlturaFonteCampo; }
	
	function getAlinhamentoCampo() { return $this->stAlinhamentoCampo; }
	
	function getNumeroColunas() { return $this->inNumeroColunas; }
	
	function getNumeroLinhas() { return $this->inNumeroLinhas; }
	
	function getSumario() { return $this->stSumario; }
	
	function addCabecalho($nome, $descricao, $espessura) {
		
		$obCampoCabecalho = new CampoTabelaPDF;

		$obCampoCabecalho->setAlinhamento($this->getAlinhamentoCabecalho());
		$obCampoCabecalho->setAlturaCelula($this->inAlturaCelulaCabecalho);

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
	
	function addCampo($nome, $espessura) {
		
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
	
	function TabelaPDF($stOrientacao='P') {

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
	
	function geraPDF(&$obListaPDF) {
		
		// Sumario
		
		if ( strlen($this->getSumario()) > 0 ) {
			$obListaPDF->ln();
			$obCampoSumario = new CampoTabelaPDF;	
			$obCampoSumario->setAlinhamento('C');
			$obCampoSumario->setAlturaCelula(10);
			$obCampoSumario->setAlturaFonte(10);
			$obCampoSumario->setBorda('0');
			$obCampoSumario->setNomeCampo('sumario');
			$obCampoSumario->setDescricaoCampo($this->getSumario());
			if ($this->getOrientacao() == 'L') {
				$obCampoSumario->setEspessuraCelula(270);
			} else {
				$obCampoSumario->setEspessuraCelula(190);
			}
			$obCampoSumario->geraCelulaPDF(&$obListaPDF);
		}
		
		// Cabe�alho
				
		$obListaPDF->ln();		
		foreach ($this->arCabecalho as $obCampoCabecalho) {
			$obCampoCabecalho->geraCelulaPDF(&$obListaPDF);
		}
		
		// Conte�do
		
		$rsDados = $this->rsDados;		
		foreach ($rsDados as $registro) {
			$obListaPDF->ln();
			foreach ($this->arCamposTabela as $obCampo) {
				$nomeCampo = $obCampo->getNomeCampo();
				$obCampo->setDescricaoCampo($registro[$nomeCampo]);			
				$obCampo->geraCelulaPDF(&$obListaPDF);
			}			
		}		
	}
	
}
?>