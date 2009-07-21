<?php
/**
* RecordSet.class.php
* 05/01/2008
* 
* $Id: $
*/

class RecordSet {
	
	var $arResultados;
	var $inLinhas;
	var $inColunas;
	var $inPosicao;
	
	public function RecordSet()
	{	
		$this->arResultados = array();
		$this->inLinhas = 0;
		$this->inColunas = 0;
		$this->inPosicao = null;
	}
	
	/**
	* @param 	roConsulta: executada em obConexao->executaSQL(stSQL)
	* @return 	void
	* */
	public function setResultados($roConsulta)
	{
		while ($ln = mysql_fetch_assoc($roConsulta))
		{
			$this->addRegistro($ln);
			$this->inLinhas = $this->inLinhas + 1;
		}
		if (count($this->getLinhas()) > 0)
		{
			$this->inColunas = count($this->getRegistro(0));
		}
	}
	
	public function setPosicao($integer)
	{
		$this->inPosicao = $integer;
	}
	
	public function setProximo()
	{
		$this->setPosicao( $this->getPosicao() + 1 );
	}
	
	public function addRegistro($registro)
	{
		$this->arResultados[] = $registro;
	}
	
	/**
	 * Retorna um Array com os Elementos do Recordset
	 * @param 	void
	 * @return 	Array: Conteudo do Recordset
	 */
	public function getResultados()
	{
		return $this->arResultados;
	}
	
	public function getLinhas()
	{
		return $this->inLinhas;
	}
	
	public function getColunas()
	{
		return $this->inColunas;
	}
	
	public function getPosicao()
	{
		return $this->inPosicao;
	}
	
	public function getRegistro()
	{
		if ( isset($this->arResultados[$this->getPosicao()]) )
		{
			$retorno = $this->arResultados[$this->getPosicao()];
			$this->setProximo();
		}
		else
		{
			$this->setPosicao(0);
			$retorno = false;
		}
		return $retorno;
	}
	
	public function getValor($stCampo)
	{
		if (isset($this->arResultados[$this->getPosicao()][$stCampo]))
		{
			return $this->arResultados[$this->getPosicao()][$stCampo];
		}
		else
		{
			return null;
		}
	}

}
?>
