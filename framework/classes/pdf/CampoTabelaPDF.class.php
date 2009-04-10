<?php
/**
 	* Framework GBAPHP
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Classe de Campo de Tabela em PDF
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

class CampoTabelaPDF
{
	var $stNomeCampo;
	var $stDescricaoCampo;
	var $stFonte;
	var $stEstiloFonte;
	var $inAlturaFonte;
	var $stAlinhamento;
	var $inEspessuraCelula;
	var $inAlturaCelula;
	var $stBorda;
	
	public function setNomeCampo($stValor)
	{
		$this->stNomeCampo = $stValor;
	}
	
	public function setDescricaoCampo($stValor)
	{
		$this->stDescricaoCampo = $stValor;
	}
	
	public function setFonte($stValor)
	{
		$this->stFonte = $stValor;
	}
	
	public function setEstiloFonte($stValor)
	{
		$this->stEstiloFonte = $stValor;
	}
	
	public function setAlturaFonte($inValor)
	{
		$this->inAlturaFonte = $inValor;
	}
	
	public function setAlinhamento($stValor)
	{
		$this->stAlinhamento = $stValor;
	}
	
	public function setEspessuraCelula($inValor)
	{
		$this->inEspessuraCelula = $inValor;
	}
	
	public function setAlturaCelula($inValor)
	{
		$this->inAlturaCelula = $inValor;
	}
	
	public function setBorda($stValor)
	{
		$this->stBorda = $stValor;
	}
	
	public function getNomeCampo()
	{
		return $this->stNomeCampo;
	}
	
	public function getDescricaoCampo()
	{
		return $this->stDescricaoCampo;
	}
	
	public function getFonte()
	{
		return $this->stFonte;
	}
	
	public function getEstiloFonte()
	{
		return $this->stEstiloFonte;
	}
	
	public function getAlturaFonte() 
	{
		return $this->inAlturaFonte;
	}
	
	public function getAlinhamento()
	{
		return $this->stAlinhamento;
	}
	
	public function getEspessuraCelula()
	{
		return $this->inEspessuraCelula;
	}
	
	public function getAlturaCelula()
	{
		return $this->inAlturaCelula;
	}
	
	public function getBorda()
	{
		return $this->stBorda;
	}
	
	/**
	 * Método Construtor
	 * @return void
	 */
	public function campoTabelaPDF()
	{
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
	
	public function montaCelulaPDF()
	{
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
	
	public function geraCelulaPDF(&$obListaPDF)
	{
		$obListaPDF->SetFont($this->stFonte, $this->stEstiloFonte, $this->inAlturaFonte);
		$obListaPDF->Cell($this->inEspessuraCelula, $this->inAlturaCelula, $this->stDescricaoCampo, $this->stBorda, 0, $this->stAlinhamento, 0, '');		
	}
}
?>