<?
/**
 	* Framework GBA
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Objeto de Paginacao de Resultados
    * Data de Criacao: 29/09/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package componentes/interface
    * @subpackage
    *     
    * $Id: $
    *     
    * Casos de uso: 
*/


include_once (GBA_PATH_CLA_INT . 'ITabela.class.php');
include_once (GBA_PATH_CLA_BDA . 'RecordSet.class.php');

class ITabelaPaginacao extends ITabela {

	public $arCabecalho; 		        // Array de Objetos Texto ou Link com as Colunas do Cabecalho
	public $arChavesCampos; 		    // Array de Strings com Chaves dos Campos do RecordSet
	public $inPaginaAtual;
	public $inTotalPaginas;
	public $inLinhasPorPagina;
	public $obRecordSet;
	
	public $inResultadoInicial;
	public $inResultadoFinal;
	
	public $stEstiloCssCabecalho;       // Estilo CSS padrao para as Celulas do CabeÃ§alho
	public $arEstiloCssAlternado; 		// Array de Estilos Alternados para Linhas de Resultado
    public $stEStiloCSSResultados;      // Estilo CSS padrao para as Celulas de Resultado
	public $arEstiloCSSCelulasRes; 		// Array de Estilos CSS das Celulas de Resultado
	
	
	// Implementar Links para Edicao nos Registros usando os atributos abaixo
	
	public $stChavePrimaria; 			// String com o nome do Campo Chave Primaria
	public $arCamposEdicao; 			// Array de Campos Chave que serao Links para Edicao
	public $stLinkEdicao; 				// String Contendo a URL para Edicao de Registro
										// Concatena o link de Edicao com a Chave Primaria definida linkEdicao?campo=[valor]
	public $stEventoClickLinkEdicao;	// Instrucoes para Eventos do Link de Edicao
	
	// Links para navegacao e paginacao
	public $obDivNavegacao;
	
	// Array de campos para tratamento de moeda (valor)
	public $arCamposValor;
	
	// Array de campos para tratamento de datas
	public $arCamposData;

	
	public function ITabelaPaginacao() {
	
		parent::ITabela();
		$this->arCabecalho = array();
		$this->arChavesCampos = array();
		$this->inPaginaAtual = 1;
		$this->inTotalPaginas = 1;
		$this->inLinhasPorPagina = 10;
		$this->obRecordSet = new RecordSet;
		$this->stEstiloCssCabecalho = 'ln0';
		$this->arEstiloCssAlternado = array('ln1', 'ln2');
		$this->arEstiloCSSCelulasRes = array();
		
		$this->stChavePrimaria = false;
		
		$this->arCamposEdicao = array();
		$this->stLinkEdicao = '';
		
		$this->obDivNavegacao = new IDiv();
		
		$this->arCamposData = array();
		$this->arCamposValor = array();
		
	}
	
	// Metodos SET
	
	public function setPaginaAtual($inPgAtual) { $this->inPaginaAtual = $inPgAtual; }
	
	public function setLinhasPorPagina($inLnPg) { $this->inLinhasPorPagina = $inLnPg; }
	
	public function setRecordSet($obRecordSet) { $this->obRecordSet = $obRecordSet; }
	
	public function setChavesCampos($arChaves) { $this->arChavesCampos = $arChaves; }
	
	public function setCabecalho($arCabecalho) { $this->arCabecalho = $arCabecalho; }
	
	public function setResultadoInicial($inResIni) { $this->inResultadoInicial = $inResIni; }
	
	public function setResultadoFinal($inResFim) { $this->inResultadoFinal = $inResFim; }

	public function setChavePrimaria( $stChave ) { $this->stChavePrimaria = $stChave; }
	
	public function setCamposEdicao( $arCampos ) { $this->arCamposEdicao = $arCampos; }
	
	public function setLinkEdicao( $stLink ) { $this->stLinkEdicao = $stLink; }
	
	public function setEventoClickLinkEdicao( $stInstrucoesClick ) { $this->stEventoClickLinkEdicao = $stInstrucoesClick; }
	
	public function setCamposValor( $arCamposVal ) { $this->arCamposValor = $arCamposVal; }
	
	public function setCamposData( $arCamposData ) { $this->arCamposData = $arCamposData; }
	
	/* Metodos GET */
	
	public function getLinkEdicao() { return $this->stLinkEdicao; }
	
	public function getEventoClickLinkEdicao() { return $this->stEventoClickLinkEdicao; }
	
	public function getChavePrimaria() { return $this->stChavePrimaria; }
	
	
	
	/**
	 * Define um Estilo para a Celula de Resultado conforme a chave
	 */	
	public function addCSSCelulaResultado( $stChave, $stCss ) {
		
		$arEstiloCSSCelulasRes = $this->arEstiloCSSCelulasRes;
		$arEstiloCSSCelulasRes[$stChave] = $stCss;
		$this->arEstiloCSSCelulasRes = $arEstiloCSSCelulasRes;
		return true;

	}
	
	/**
	 * Metodo para popular Linhas e Celulas da Tabela
	 */ 
	public function montaPaginacao() {
		
		$obRecordSet = $this->obRecordSet;
		$inTotalResultados = $obRecordSet->getLinhas();
		
		if ($this->inPaginaAtual <= 0) {
			$this->inPaginaAtual = 1;
		}
		
		
		$inTotalPaginas = $inTotalResultados / $this->inLinhasPorPagina;		
		$this->inTotalPaginas = $inTotalPaginas;
		
		$obLinhaCabecalho = new ILinha();
		$obLinhaCabecalho->setCss($this->stEstiloCssCabecalho);
		
		$arCabecalho = $this->arCabecalho;
		
		for ($i=0; $i<count($arCabecalho); $i++) {
			$obCelula = new ICelula();
			$obCelula->addComponente(new ITexto($arCabecalho[$i]));
			$obLinhaCabecalho->addComponente($obCelula);
		}
		$this->addComponente($obLinhaCabecalho);
		
		// montar celulas de conteudo do restante da tabela de paginacao
		$arChaves = $this->arChavesCampos;
		
		$arEstilosResultados = $this->arEstiloCSSCelulasRes;
		
		$obRecordSet = $this->obRecordSet;
		$obRecordSet->setPosicao(($this->inPaginaAtual - 1) * $this->inLinhasPorPagina);
		$inContador = 1;

		while( ($arLin = $obRecordSet->getRegistro()) && ($inContador <= $this->inLinhasPorPagina) )  {

				$obLinhaResultado = new ILinha;

				// Definir aqui o estilo CSS da Linha
				
				for ($i=0; $i<count($arChaves); $i++) {
					
					$obCelula = new ICelula();
					$stConteudo = (strlen($arLin[$arChaves[$i]]) > 0) ? ($arLin[$arChaves[$i]]) : '&nbsp;';
					
					if ($stConteudo != '&nbsp;' && in_array($arChaves[$i], $this->arCamposData)) {
						$stConteudo = Sistema::formataDataHora($stConteudo);
					}

					if ($stConteudo != '&nbsp;' && in_array($arChaves[$i], $this->arCamposValor)) {
						$stConteudo = Sistema::formataNumeroParaLeitura($stConteudo);
					}
					
					// Define Link de Edicao ou Texto simples
					
					if (in_array($arChaves[$i], $this->arCamposEdicao)) {
						
						$stLinkEdicao = $this->getLinkEdicao();
						$stEventoClickLinkEdicao = $this->getEventoClickLinkEdicao();
						
						for ($y=0; $y<count($arChaves); $y++) {
							
							$stLinkEdicao = str_replace('['.$arChaves[$y].']', $arLin[$arChaves[$y]], $stLinkEdicao);
							$stEventoClickLinkEdicao = str_replace('['.$arChaves[$y].']', $arLin[$arChaves[$y]], $stEventoClickLinkEdicao);
							
						}
						
						if ($this->getLinkEdicao() != '#') {
							
							$stLinkEdicao = $stLinkEdicao . '?' . $this->getChavePrimaria() . '=' . $arLin[$this->getChavePrimaria()];
							
						}
						
						$obConteudo = new ILink($stConteudo, $stLinkEdicao);
						$obConteudo->obEvento->setOnClick($stEventoClickLinkEdicao);
						
					} else {
						
						$obConteudo = new ITexto($stConteudo);
						
					}
					
					$obCelula->addComponente($obConteudo);
					
					if (isset($arEstilosResultados[$arChaves[$i]])) {
						$obCelula->setCss($arEstilosResultados[$arChaves[$i]]);
					}
					
					$obLinhaResultado->addComponente($obCelula);
				}
				
				$this->addComponente($obLinhaResultado);
				++$inContador;

		}
		
		// Link Anterior
		
		if ($this->inPaginaAtual > 1) {
			
			$stLinkAnterior = '?pg=' . ($this->inPaginaAtual - 1);
			$obLinkAnterior = new ILink('Anterior', $stLinkAnterior);
			$this->obDivNavegacao->addComponente(array(new ITexto('&nbsp;'), $obLinkAnterior, new ITexto('&nbsp;')));
			
		}
		
		// Link Proximo
		
		if ($this->inTotalPaginas > $this->inPaginaAtual) {
			
			$stLinkProximo = '?pg=' . ($this->inPaginaAtual + 1);
			$obLinkProximo = new ILink('Próximo', $stLinkProximo);
			$this->obDivNavegacao->addComponente(array(new ITexto('&nbsp;'), $obLinkProximo, new ITexto('&nbsp;')));
			
		}
		
	}
	
	/**
	 * Overload
	 */ 
	public function montaHtml() {
		
		$this->montaPaginacao();
		parent::montaHtml();
		$this->obDivNavegacao->montaHtml();
		
		$stHtml = $this->obDivNavegacao->getHtml() . $this->getHtml() . $this->obDivNavegacao->getHtml();
		$this->stHtml = $stHtml;		
		
	}

}
?>