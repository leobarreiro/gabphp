<?php

class CampoTabelaPDF {
	var $stNomeCampo;
	var $stDescricaoCampo;
	var $stFonte;
	var $stEstiloFonte;
	var $inAlturaFonte;
	var $stAlinhamento;
	var $inEspessuraCelula;
	var $inAlturaCelula;
	var $stBorda;
	
	function setNomeCampo($stValor) { $this->stNomeCampo = $stValor; }
	function setDescricaoCampo($stValor) { $this->stDescricaoCampo = $stValor; }
	function setFonte($stValor) { $this->stFonte = $stValor; }
	function setEstiloFonte($stValor) { $this->stEstiloFonte = $stValor; }
	function setAlturaFonte($inValor) { $this->inAlturaFonte = $inValor; }
	function setAlinhamento($stValor) { $this->stAlinhamento = $stValor; }
	function setEspessuraCelula($inValor) { $this->inEspessuraCelula = $inValor; }
	function setAlturaCelula($inValor) { $this->inAlturaCelula = $inValor; }
	function setBorda($stValor) { $this->stBorda = $stValor; }
	
	function getNomeCampo() { return $this->stNomeCampo; }
	function getDescricaoCampo() { return $this->stDescricaoCampo; }
	function getFonte() { return $this->stFonte; }
	function getEstiloFonte() { return $this->stEstiloFonte; }
	function getAlturaFonte() { return $this->inAlturaFonte; }
	function getAlinhamento() { return $this->stAlinhamento; }
	function getEspessuraCelula() { return $this->inEspessuraCelula; }
	function getAlturaCelula() { return $this->inAlturaCelula; }
	function getBorda() {return $this->stBorda; }
	
	function campoTabelaPDF() {
		$this->stNomeCampo = '';
		$this->stDescricaoCampo = '';
		$this->stFonte = 'Arial';
		$this->stEstiloFonte = '';
		$this->inAlturaFonte = 10;
		$this->stAlinhamento = 'C';
		$this->inEspessuraCelula = 30;
		$this->inAlturaCelula = 5;
		$this->stBorda = 'LTRB';		
	}
	
	function montaCelulaPDF() {
		$arCelulaPDF = array();
		$arCelulaPDF['nomeCampo'] = $this->stNomeCampo;
		$arCelulaPDF['descricao'] = $this->stDescricaoCampo;
		$arCelulaPDF['fonte'] = $this->stFonte;
		$arCelulaPDF['estiloFonte'] = $this->stEstiloFonte;
		$arCelulaPDF['alturaFonte'] = $this->inAlturaFonte;
		$arCelulaPDF['alinhamento'] = $this->stAlinhamento;
		$arCelulaPDF['espessuraCelula'] = $this->inEspessuraCelula;
		$arCelulaPDF['alturaCelula'] = $this->inAlturaCelula;
		$arCelulaPDF['borda'] = $this->stBorda;		
	}
	
	function geraCelulaPDF(&$obListaPDF) {
		$obListaPDF->SetFont($this->stFonte, $this->stEstiloFonte, $this->inAlturaFonte);
		$obListaPDF->Cell($this->inEspessuraCelula, $this->inAlturaCelula, $this->stDescricaoCampo, $this->stBorda, 0, $this->stAlinhamento, 0, '');		
	}
}
?>