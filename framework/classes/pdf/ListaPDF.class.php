<?php
// 27/11/2007
error_reporting(GBA_ERRORS);
include_once (GBA_PATH_FWK . 'Fpdf/fpdf.php');
include_once(GBA_PATH_FWK . 'Classes/FusoHorario.class.php');

class ListaPDF extends FPDF {
	
	var $stOrientacao;
	var $arCabecalhos;
	var $arCampos;
	var $rsDados;
	var $arEspessuras;
	var $stNomeArquivo;
	var $stFonte;
	var $inAlturaFonte;
	var $arTabelas;
	var $tituloCabecalho;
	
	function setOrientacao($stValor) { $this->stOrientacao = $stValor; }
	function setCabecalhos($arValor) { $this->arCabecalhos = $arValor; }
	function setCampos($arValor) { $this->arCampos = $arValor; }
	function setDados($rsValor) { $this->rsDados = $rsValor; }
	function setEspessuras($arValor) { $this->arEspessuras = $arValor; }
	function setNomeArquivo($stValor) { $this->stNomeArquivo = $stValor; }
	function setFonte($stValor) { $this->stFonte = $stValor; }
	function setAlturaFonte($inValor) { $this->inAlturaFonte = $inValor; }
	function setTituloCabecalho($stValor) { $this->tituloCabecalho = $stValor; }
	
	function getOrientacao() { return $this->stOrientacao; }
	function getCabecalhos() { return $this->arCabecalhos; }
	function getCampos() { return $this->arCampos; }
	function getDados() { return $this->rsDados; }
	function getEspessuras() { return $this->arEspessuras; }
	function getNomeArquivo() { return $this->stNomeArquivo; }
	function getFonte() { return $this->stFonte; }
	function getAlturaFonte() { return $this->inAlturaFonte; }
	function getTituloCabecalho() { return $this->tituloCabecalho; }
	
	/* Metodo Construtor */
	function ListaPDF($stOrientacao='P') {
		
		$this->stOrientacao = $stOrientacao;
		$this->stNomeArquivo = 'exporta.pdf';
		$this->stFonte = 'Arial';
		$this->inAlturaFonte = 10;
		$this->tituloCabecalho = 'Relatorio';
		parent::FPDF($this->getOrientacao(), 'mm', 'A4');
		$this->SetMargins(10, 22, 10);
		
	}
	
	function InitListaPDF() {
		$this->Open();
		$this->AddPage();		
	}	
	
	function nroPaginaAtual() {
		return $this->page;
	}
	
	function nroTotalPaginas() {
		return count($this->pages);
	}
	
/*
TODO: revisar o uso do logotipo padrão como variavel de ambiente e não string fixa
*/
	function Header() {
	    $logo = GBA_PATH_SISTEMA . 'Images/logoPdf.png';		
	    $this->Image($logo, 10, 10);
	    $this->SetFont('Arial','B',12);
	    //Move to the right
	    $this->Cell(10);
	    //Title
	    $this->Cell(0, 8, $this->getTituloCabecalho(), 0, 0, 'C');
	    //Line break
	    $this->Ln();
		$dataAtual = new FusoHorario();
		$dataAtual->setFuso( GBA_FUSO_HORARIO );
		$dataAtual->setFormatoData("d/m/Y H:i");
		$dataAtual->calculaDataHoraLocal();
	    
	    $this->SetFont('Arial', '', 9);
	    $this->Cell(5);
	    $this->Cell(0, 2, 'Emitido em '.$dataAtual->getDataLocal().'h.', 0, 0, 'C');
	    $this->Ln();
	    $this->Ln();
	}
	
	function Footer() {
	    //Position at 1.5 cm from bottom
	    $this->SetY(-15);
	    //Arial italic 8
	    $this->SetFont('Arial','I',8);
	    //Page number
	    //$this->Cell(0,10,'Página '.$this->nroPaginaAtual().' de '.$this->nroTotalPaginas(), 0, 0, 'C');
	    $this->Cell(0,10,'Página '.$this->nroPaginaAtual(), 0, 0, 'C');
	}
	
	function geraPDF() {
		/*
		$logoMarca = GBA_PATH_SISTEMA . 'Images/logo.png';
		$pdf->Image($logoMarca, 10, 10, '', '', 'png');		
		$pdf->SetY(30);
		*/
		$this->Output($this->stNomeArquivo, 'D');
	}	
}
?>