<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Classe de Lista de Dados em PDF - estende FPDF
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

error_reporting(GBA_ERRORS);
include_once (GBA_PATH_FWK . 'Fpdf/fpdf.php');
include_once(GBA_PATH_FWK . 'Classes/FusoHorario.class.php');

class ListaPDF extends FPDF
{
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
	
	public function setOrientacao($stValor)
	{
		$this->stOrientacao = $stValor;
	}
	
	public function setCabecalhos($arValor)
	{
		$this->arCabecalhos = $arValor;
	}
	
	public function setCampos($arValor)
	{
		$this->arCampos = $arValor;
	}
	
	public function setDados($rsValor)
	{
		$this->rsDados = $rsValor;
	}
	
	public function setEspessuras($arValor)
	{
		$this->arEspessuras = $arValor;
	}
	
	public function setNomeArquivo($stValor)
	{
		$this->stNomeArquivo = $stValor;
	}
	
	public function setFonte($stValor)
	{
		$this->stFonte = $stValor;
	}
	
	public function setAlturaFonte($inValor)
	{
		$this->inAlturaFonte = $inValor;
	}
	
	public function setTituloCabecalho($stValor)
	{
		$this->tituloCabecalho = $stValor;
	}
	
	public function getOrientacao() 
	{
		return $this->stOrientacao;
	}
	
	public function getCabecalhos() 
	{
		return $this->arCabecalhos;
	}
	
	public function getCampos()
	{
		return $this->arCampos;
	}
	
	public function getDados()
	{
		return $this->rsDados;
	}
	
	public function getEspessuras()
	{
		return $this->arEspessuras;
	}
	
	public function getNomeArquivo()
	{
		return $this->stNomeArquivo;
	}
	
	public function getFonte()
	{
		return $this->stFonte;
	}
	
	public function getAlturaFonte()
	{
		return $this->inAlturaFonte;
	}
	
	public function getTituloCabecalho()
	{
		return $this->tituloCabecalho;
	}
	
	/* Metodo Construtor */
	public function ListaPDF($stOrientacao='P')
	{	
		$this->stOrientacao = $stOrientacao;
		$this->stNomeArquivo = 'exporta.pdf';
		$this->stFonte = 'Arial';
		$this->inAlturaFonte = 10;
		$this->tituloCabecalho = 'Relatorio';
		parent::FPDF($this->getOrientacao(), 'mm', 'A4');
		$this->SetMargins(10, 22, 10);	
	}
	
	public function InitListaPDF()
	{
		$this->Open();
		$this->AddPage();		
	}	
	
	public function nroPaginaAtual()
	{
		return $this->page;
	}
	
	public function nroTotalPaginas()
	{
		return count($this->pages);
	}
	
	/*
	 * TODO: revisar o uso do logotipo padrão como variavel de ambiente e não string fixa
	*/
	public function Header()
	{
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
	
	public function Footer()
	{
	    //Position at 1.5 cm from bottom
	    $this->SetY(-15);
	    //Arial italic 8
	    $this->SetFont('Arial','I',8);
	    //Page number
	    //$this->Cell(0,10,'Página '.$this->nroPaginaAtual().' de '.$this->nroTotalPaginas(), 0, 0, 'C');
	    $this->Cell(0,10,'Página '.$this->nroPaginaAtual(), 0, 0, 'C');
	}
	
	public function geraPDF()
	{
		/*
		$logoMarca = GBA_PATH_SISTEMA . 'Images/logo.png';
		$pdf->Image($logoMarca, 10, 10, '', '', 'png');		
		$pdf->SetY(30);
		*/
		$this->Output($this->stNomeArquivo, 'D');
	}
}
?>