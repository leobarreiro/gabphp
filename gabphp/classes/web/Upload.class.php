<?

class Upload {
	var $tempName;
	var $arq;
	var $mimeType;
	var $path;
	var $weight;
	var $sumario;
	
	function Upload ($tempName, $arq, $path, $mimeType)
	{
		$this->tempName = $tempName;
		$this->path = $path;
		$this->mimeType = $mimeType;
		
		$retiraveis = array(' ', ',', ';', ':', '^', '~', '+', '=', '[', ']', '{', '}', '!', '@', '#', '$', '%', '&', '*', '(', ')', '/', '|', '?');
		$substitutos = array();
		for ($r=0; $r<count($retiraveis); ++$r)
		{
			$substitutos[] = '';
		}
		$this->arq = str_replace($retiraveis, $substitutos, $arq);
	}
	
	function DefinePrefixo($prefixo)
	{
		$this->arq = $prefixo . $this->arq;
	}
	
	function DefinePeso($weight)
	{
		$this->weight = $weight;
	}
	
	function RetornaPeso($medida='Kb')
	{
		if ($medida == 'Kb')
		{
			$coef = 1024;
			$decimais = 2;
		}
		elseif ($medida == 'Mb')
		{
			$coef = 1048576;
			$decimais = 6;
		}
		else
		{
			$medida = 'bytes';
			$coef = 1;
			$decimais = 0;
		}
		$tamanho = ($this->weight) / $coef;
		$tamanho = number_format($tamanho, $decimais, ',', '.');
		if ($tamanho > 0)
			$tamanho = $tamanho . ' ' . $medida;
		else 
			$tamanho = 'n.d.';
		return $tamanho;
	}
	
	function RetornaNomeArquivo()
	{
		return $this->arq;
	}
	
}


class UploadImagem extends Upload {
	
	var $tempName;
	var $arq;
	var $mimeType;
	var $path;
	var $weight;
	var $sumario;
	
	var $width;
	var $height;
	var $newWeight;
	var $thumbPath;
	var $borda;
	var $corBorda;
	var $corFundo;
	var $etiqueta;

	// Somente para imagens
	function salvaOtimizadoGD ($alturaMax, $larguraMax, $pesoMax)
	{
		if (!file_exists($this->path))
		{
			mkdir($this->path);
			chmod($this->path, 0777); // adicionado em 13/01/2007
		}
		
		$mimes = array('image/gif', 'image/jpeg', 'image/png');
		
		if (in_array($this->mimeType, $mimes))
		{
			$dadosImg = getimagesize($this->tempName);
			$larguraAtual = $dadosImg[0];
			$alturaAtual = $dadosImg[1];
			if ($larguraAtual > $larguraMax || $alturaAtual > $alturaMax)
			{
				if ($larguraAtual > $alturaAtual)
				{
					$coef = $larguraMax / $larguraAtual;
					$largura = $coef * $larguraAtual;
					$altura = $coef * $alturaAtual;
				}
				else
				{
					$coef = $alturaMax / $alturaAtual;
					$largura = $coef * $larguraAtual;
					$altura = $coef * $alturaAtual;
				}
			}
			else
			{
				$largura = $larguraAtual;
				$altura = $alturaAtual;
			}
			$this->width = number_format($largura, '0', '', '');
			$this->height = number_format($altura, '0', '', '');
			
			$nova = imagecreatetruecolor($this->width, $this->height);
			$imagemPath = $this->path . $this->arq;
			
			if ($this->mimeType == 'image/gif')
			{
				$im = imagecreatefromgif($this->tempName);
				// imagecopyresized($nova, $im, 0, 0, 0, 0, $largura, $altura, $larguraAtual, $alturaAtual);
				imagecopyresampled($nova, $im, 0, 0, 0, 0, $largura, $altura, $larguraAtual, $alturaAtual);
				imagegif($nova, $imagemPath);
			}
			elseif ($this->mimeType == 'image/png')
			{
				$im = imagecreatefrompng($this->tempName);
				// imagecopyresized($nova, $im, 0, 0, 0, 0, $largura, $altura, $larguraAtual, $alturaAtual);
				imagecopyresampled($nova, $im, 0, 0, 0, 0, $largura, $altura, $larguraAtual, $alturaAtual);
				imagepng($nova, $imagemPath);
			}
			// Default: image/jpeg
			else
			{
				$im = imagecreatefromjpeg($this->tempName);
				imagecopyresampled($nova, $im, 0, 0, 0, 0, $largura, $altura, $larguraAtual, $alturaAtual);
				imagejpeg($nova, $imagemPath, 85);
			}
			
			@chmod($imagemPath, 0777);
			$this->newWeight = @filesize($imagemPath);
			@imagedestroy($im);
		}
		else 
		{
			$this->width = NULL;
			$this->height = NULL;
			$this->newWeight = NULL;
		}
		$this->borda = false;
		$this->corBorda = null;
		$this->corFundo = null;
		$this->etiqueta = null;
	}
	
	function geraThumb($pathThumb, $alturaThumb, $larguraThumb)
	{
		$this->thumbPath = $this->path . $pathThumb;
		$imagemPath = $this->path . $this->arq;
		$imagemThumb = $this->thumbPath . $this->arq;
		
		if (!file_exists($this->thumbPath))
		{
			mkdir($this->thumbPath);
			chmod($this->thumbPath, 0777); // adicionado em 13/01/2007
		}
		
		if (isset($this->newWeight) && $this->newWeight != NULL && file_exists($imagemPath))
		{
			$dadosImg = getimagesize($imagemPath);
			$larguraAtual = $dadosImg[0];
			$alturaAtual = $dadosImg[1];
			if ($larguraAtual > $larguraThumb || $alturaAtual > $alturaThumb)
			{
				if ($larguraAtual > $alturaAtual)
				{
					$coef = $larguraThumb / $larguraAtual;
					$largura = $coef * $larguraAtual;
					$altura = $coef * $alturaAtual;
				}
				else
				{
					$coef = $alturaThumb / $alturaAtual;
					$largura = $coef * $larguraAtual;
					$altura = $coef * $alturaAtual;
				}
			}
			else
			{
				$largura = $larguraAtual;
				$altura = $alturaAtual;
			}
			$this->widthThumb = number_format($largura, '0', '', '');
			$this->heightThumb = number_format($altura, '0', '', '');
			
			$nova = imagecreatetruecolor($this->widthThumb, $this->heightThumb);
		
			if ($this->mimeType == 'image/gif')
			{
				$im = imagecreatefromgif($imagemPath);
				// imagecopyresized($nova, $im, 0, 0, 0, 0, $largura, $altura, $larguraAtual, $alturaAtual);
				imagecopyresampled($nova, $im, 0, 0, 0, 0, $largura, $altura, $larguraAtual, $alturaAtual);
				imagegif($nova, $imagemThumb);
			}
			elseif ($this->mimeType == 'image/png')
			{
				$im = imagecreatefrompng($imagemPath);
				// imagecopyresized($nova, $im, 0, 0, 0, 0, $largura, $altura, $larguraAtual, $alturaAtual);
				imagecopyresampled($nova, $im, 0, 0, 0, 0, $largura, $altura, $larguraAtual, $alturaAtual);
				imagepng($nova, $imagemThumb);
			}
			// Default: image/jpeg
			else
			{
				$im = imagecreatefromjpeg($imagemPath);
				imagecopyresampled($nova, $im, 0, 0, 0, 0, $largura, $altura, $larguraAtual, $alturaAtual);
				imagejpeg($nova, $imagemThumb, 85);
			}
		}
	}
	
	// 17/10/2006
	// Este metodo aplica uma borda a foto
	// Poderao ser disponibilizados alguns modelos de bordas conforme a conveniencia
	// Parametros de Entrada: (1) cor da borda ; (2) cor de fundo ; (3) modelo de borda
	// opacidadeBorda - de 0 a 10 : 0 mais opaco, 10 mais transparente
	function aplicaBorda($corBorda='grey', $corFundo='white', $transparenciaBorda=0)
	{
		// copiar a imagem recem formada para a memoria
		// aplicar a borda na imagem em memoria
		// salvar a nova imagem com borda no lugar da anterior
		
		$imagemPath = $this->path . $this->arq;
		switch($this->mimeType)
		{
			case 'image/gif';
				$im = imagecreatefromgif($imagemPath);
				break;
			case 'image/png';
				$im = imagecreatefrompng($imagemPath);
				break;
			default: case 'image/jpeg';
				$im = imagecreatefromjpeg($imagemPath);
				break;
		}
		// Exclui a Foto recem formada no metodo GeraImagem onde nao ha borda.
		// A imagem fica na memoria por enquanto.
		// unlink($imagemPath);
	
		if ($transparenciaBorda > 10)
		{
			$transparenciaBorda = 10;
		}
		if ($transparenciaBorda > 0)
		{
			$transparenciaBorda = 127 / $transparenciaBorda;
		}
	
		$corBorda = strtolower($corBorda);
		switch($corBorda)
		{
			case 'blue';
				$r = 0;
				$g = 0;
				$b = 255;
				break;
			case 'celeste';
				$r = 0;
				$g = 127;
				$b = 255;
				break;
			case 'grey';
				$r = 127;
				$g = 127;
				$b = 127;
				break;
			case 'magenta';
				$r = 255;
				$g = 0;
				$b = 210;
				break;
			case 'red';
				$r = 255;
				$g = 0;
				$b = 0;
				break;
			case 'white';
				$r = 0;
				$g = 0;
				$b = 0;
				break;
			default: case  'black';
				$r = 255;
				$g = 255;
				$b = 255;
				break;
		}
		$this->corBorda = $corBorda;
		// $borda = imagecolorallocatealpha($im, $r, $g, $b, 0);
		$borda = imagecolorallocate($im, $r, $g, $b);
		
		$corFundo = strtolower($corFundo);
		switch($corFundo)
		{
			case 'black';
				$r = 255;
				$g = 255;
				$b = 255;
				break;
			case 'blue';
				$r = 0;
				$g = 0;
				$b = 255;
				break;
			case 'celeste';
				$r = 0;
				$g = 127;
				$b = 255;
				break;
			case 'grey';
				$r = 127;
				$g = 127;
				$b = 127;
				break;
			case 'magenta';
				$r = 255;
				$g = 0;
				$b = 210;
				break;
			case 'red';
				$r = 255;
				$g = 0;
				$b = 0;
				break;
			default: case  'white';
				$r = 0;
				$g = 0;
				$b = 0;
				break;
		}
		$this->corFundo = $corFundo;
		// $fundo = imagecolorallocatealpha($im, $r, $g, $b, 0);
		$fundo = imagecolorallocate($im, $r, $g, $b);
		
		// Desenha um retangulo como borda da imagem
		// Retangulo mais interno com a cor de fundo
		imagerectangle ($im, 2, 2, $this->width-3, $this->height-3, $fundo);
		// Retangulo intermediario com a cor da borda
		imagerectangle ($im, 1, 1, $this->width-2, $this->height-2, $borda);
		// Retangulo mais saliente com a cor de fundo
		imagerectangle ($im, 0, 0, $this->width-1, $this->height-1, $fundo);
		
		switch ($this->mimeType)
		{
			case 'image/gif';
				$salva = imagegif($im, $imagemPath);
				break;
			case 'image/png';
				$salva = imagepng($im, $imagemPath);
				break;
			default: case 'image/jpeg';
				$salva = imagejpeg($im, $imagemPath, 85);
				break;
		}
		if ($salva) $this->borda = 'Ok';
		@imagedestroy ($im);
	}
	
	function aplicaEtiqueta($etiqueta)
	{
		$salva = false;
		if (file_exists($etiqueta))
		{
			$etqMedidas = getimagesize($etiqueta);
			$etqLargura = $etqMedidas[0];
			$etqAltura = $etqMedidas[1];
			$etqMime = $etqMedidas['mime'];
			switch($etqMime)
			{
				case 'image/gif';
					$etqImg = imagecreatefromgif($etiqueta);
					//$etqImg = imagecreatefromgif($etiqueta . 'gif');
					break;
				case 'image/png';
					$etqImg = imagecreatefrompng($etiqueta);
					//$etqImg = imagecreatefrompng($etiqueta . 'png');
					break;
				default: case 'image/jpeg';
					$etqImg = imagecreatefromjpeg($etiqueta);
					//$etqImg = imagecreatefromjpeg($etiqueta . 'jpg');
					break;
			}
			
			$imagemPath = $this->path . $this->arq;
			switch($this->mimeType)
			{
				case 'image/gif';
					$im = imagecreatefromgif($imagemPath);
					//$etqImg = imagecreatefromgif($etiqueta . 'gif');
					break;
				case 'image/png';
					$im = imagecreatefrompng($imagemPath);
					//$etqImg = imagecreatefrompng($etiqueta . 'png');
					break;
				default: case 'image/jpeg';
					$im = imagecreatefromjpeg($imagemPath);
					//$etqImg = imagecreatefromjpeg($etiqueta . 'jpg');
					break;
			}
			
			imagecopy ($im, $etqImg, 2, (($this->height - $etqAltura) - 2), 0, 0, $etqLargura, $etqAltura);
			
			switch ($this->mimeType)
			{
				case 'image/gif';
					$salva = imagegif($im, $imagemPath);
					break;
				case 'image/png';
					$salva = imagepng($im, $imagemPath);
					break;
				default: case 'image/jpeg';
					$salva = imagejpeg($im, $imagemPath, 85);
					break;
			}
			@imagedestroy ($im);
		}
		
		if ($salva) 
		{
			$this->etiqueta = 'Ok';
		}
		else
		{
			$this->etiqueta = 'Nok';
		}
	}
	
}
?>