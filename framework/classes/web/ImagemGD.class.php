<?php
/*
 	* Framework GBA
    * @license : GNU Lesser General Public License v.3
    * @link http://www.cielnews.com/gba
    * 
    * Processamento de Administracao de Documentos para Imovel
    * Data de Criacao: 24/11/2008
    * @author Leopoldo Braga Barreiro
    *     
    * @package imobCIEL
    * @subpackage
    *     
    * $Id: $
    *     
    * Casos de uso: 
*/

require_once( GBA_PATH_CLA . 'Object.class.php' );

class ImagemGD extends Object {
	
	public $arquivo;
	public $inLargura;
	public $inAltura;
	public $stEtiqueta;
	
	public function ImagemGD($arqImg, $larguraMax, $alturaMax, $stEtq='') {
		
		$this->stArquivo = $arqImg;
		$this->inLargura = $larguraMax;
		$this->inAltura = $alturaMax;
		$this->stEtiqueta = $stEtq;
		
		$arDadosImg = getimagesize($arqImg);
		$larguraOriginal = $arDadosImg[0];
		$alturaOriginal = $arDadosImg[1];
		$stMimeType = $arDadosImg['mime'];
	
		if ($larguraOriginal > $larguraMax || $alturaOriginal > $alturaMax)
		{
			if ($larguraOriginal > $alturaOriginal)
			{
				$coef = $larguraMax / $larguraOriginal;
				$largura = $coef * $larguraOriginal;
				$altura = $coef * $alturaOriginal;
			}
			else
			{
				$coef = $alturaMax / $alturaOriginal;
				$largura = $coef * $larguraOriginal;
				$altura = $coef * $alturaOriginal;
			}
		}
		else
		{
			$largura = $larguraOriginal;
			$altura = $alturaOriginal;
		}
		
		$this->inLargura = number_format($largura, '0', '', '');
		$this->inAltura = number_format($altura, '0', '', '');
		
		$nova = imagecreatetruecolor($this->inLargura, $this->inAltura);
		
		$stImgPath = substr($this->stArquivo, 0, (strrpos($this->stArquivo, '/')+1));
		$stNomeArq = substr($this->stArquivo, (strrpos($this->stArquivo, '/')+1));
		
		$this->setErro($stImgPath, false);
		
		$stArquivoTemp = $stImgPath . '/tmp' . $stNomeArq;
		
		if ($stMimeType == 'image/gif')
		{
			$im = imagecreatefromgif($this->stArquivo);
			imagecopyresampled($nova, $im, 0, 0, 0, 0, $largura, $altura, $larguraOriginal, $alturaOriginal);
			imagegif($nova, $stArquivoTemp);
		}
		elseif ($stMimeType == 'image/png' || $stMimeType == 'image/x-png')
		{
			$im = imagecreatefrompng($this->stArquivo);
			imagecopyresampled($nova, $im, 0, 0, 0, 0, $largura, $altura, $larguraOriginal, $alturaOriginal);
			imagepng($nova, $stArquivoTemp);
		}
		// Default: image/jpeg
		else
		{
			$im = imagecreatefromjpeg($this->stArquivo);
			imagecopyresampled($nova, $im, 0, 0, 0, 0, $largura, $altura, $larguraOriginal, $alturaOriginal);
			imagejpeg($nova, $stArquivoTemp, 85);
		}
		imagedestroy($im);
		
		if (file_exists($stArquivoTemp)) {
			unlink($this->stArquivo);
			if (rename($stArquivoTemp, $this->stArquivo)) {
				return true;
			}
		} else {
			return false;
		}

	}
	
	
}
?>