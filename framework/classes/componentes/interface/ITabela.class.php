<?php
/*
 * Tabela.class.php
 * 28/12/2007
*/
include_once (GBA_PATH_CLA_INT . 'IComponenteBase.class.php');
include_once (GBA_PATH_CLA_INT . 'ILinha.class.php');

class ITabela extends IComponenteBase {
	
    var $stAlign;
    var $stWidth;
    var $stHeight;
    var $stCellPadding;
    var $stCellSpacing;
    
    function ITabela() {
        parent::IComponenteBase();
        $this->stAlign = 'center';
        $this->stWidth = '';
        $this->stHeight = '';
        $this->stCellPadding = '';
        $this->stCellSpacing = '';
    }
    
    function setAlign($string) { $this->stAlign = $string; }
    function setWidth($string) { $this->stWidth = $string; }
    function setHeight($string) { $this->stHeight = $string; }
    function setCellPadding($string) { $this->stCellPadding = $string; }
    function setCellSpacing($string) { $this->stCellSpacing = $string; }
    
    function getAlign() { return $this->stAlign; }
    function getWidth() { return $this->stWidth; }
    function getHeight() { return $this->stHeight; }
    function getCellPadding() { return $this->stCellPadding; }
    function getCellSpacing() { return $this->stCellSpacing; }
    
    /**
     * Adiciona nova Linha a Tabela
     *
     * @param ICelula $obCelula
     * @param boolean $boNovaLinha
     * @param String $stCssNovaLinha
     */
    function addCelula($obCelula, $boNovaLinha=false, $stCssNovaLinha='') {
        
        if ($boNovaLinha) {
            $obLinha = new ILinha;
            if (strlen($stCssNovaLinha)) {
                $obLinha->setCss($stCssNovaLinha);
            }
            $obLinha->addComponente($obCelula);
            $this->addComponente($obLinha);
        } else {
            $arLinha = $this->arComponente;
            $obUltimaLinha = $arLinha[count($arLinha)-1];
            $obUltimaLinha->addComponente($obCelula);
            $arLinha[count($arLinha)-1] = $obUltimaLinha;
            $this->arComponente = $arLinha;
        }
    
    }
    
    /**
     * Adiciona uma linha a Tabela
     * @param Array Componentes
     * @param Array Larguras de Celulas
     * @param String Estilo CSS
     * @return boolean
     */
    function addLinha($arComponentes, $arLarguras=array(), $stEstiloCss='') {
        
        if (!is_array($arComponentes)) return false;
        
        $obLinha = new ILinha;
        $obLinha->setCss($stEstiloCss);
        
        for ($x=0; $x<count($arComponentes); $x++) {
            
            $obComponente = $arComponentes[$x];
            
            if (is_object($obComponente)) {
                
                if (strtolower(get_class($arComponentes[$x])) == 'icelula') {
                    
                    if (isset($arLarguras[$x])) {
                        $obComponente->setWidth($arLarguras[$x]);
                    }
                    $obLinha->addComponente($arComponentes[$x]);
                    
                } else {
                    
                    $obCelula = new ICelula;
                    if (isset($arLarguras[$x])) {
                        $obCelula->setWidth($arLarguras[$x]);
                    }
                    $obCelula->addComponente($obComponente);
                    $obLinha->addComponente($obCelula);
                    
                }
                
            } else {
                
                $obTexto = new ITexto($obComponente);
                $obCelula = new ICelula;
                if (isset($arLarguras[$x])) {
                    $obCelula->setWidth($arLarguras[$x]);
                }
                $obCelula->addComponente($obTexto);
                $obLinha->addComponente($obCelula);
                
            }
            
        }
        
        $this->addComponente($obLinha);
        return true;
        
    }
    
    
    function novaLinha($stNomeId='', $stCss='') {	
        $obLinha = new ILinha;
        if (strlen($stId)) {
            $obLinha->setNomeId($stNomeId);
        }
        if (strlen($stCss)) {
            $obLinha->setCss($stCss);
        }
        $this->arComponente[] = $obLinha;	
    }
    
    
    function montaHtml() {
        $stHtml = "\n" . '<table';
    
        if (strlen($this->getId())) {
            $stHtml .= ' id="' . $this->getId() . '"';
        }
        if (strlen($this->getAlign())) {
            $stHtml .= ' align="' . $this->getAlign() . '"';
        }
        if (strlen($this->getCellPadding())) {
            $stHtml .= ' cellpadding=' . $this->getCellPadding();
        }
        if (strlen($this->getCellSpacing())) {
            $stHtml .= ' cellspacing=' . $this->getCellSpacing();
        }
        if (strlen($this->getWidth())) {
            $stHtml .= ' width="' . $this->getWidth() . '"';
        }
        if (strlen($this->getHeight())) {
            $stHtml .= ' height="' . $this->getHeight() . '"';
        }
        if (strlen($this->getStyle())) {
            $stHtml .= ' style="' . $this->getStyle() . '"';
        }
        if (strlen($this->getCss())) {
            $stHtml .= ' class="' . $this->getCss() . '"';
        }
        $this->obEvento->montaHtml();
        $stHtml .= $this->obEvento->getHtml();
        
        $stHtml .= '>' . "\n";
        
        foreach ($this->arComponente as $obComponente) {
            $obComponente->montaHtml();
            $stHtml .= "    " . $obComponente->getHtml() . "\n";
        }
            
        $stHtml .= '</table>' . "\n";
        $this->stHtml = $stHtml; 
    }


}

?>