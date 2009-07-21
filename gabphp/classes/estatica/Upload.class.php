<?

class Upload {
	var $tempName;
	var $arq;
	var $mimeType;
	var $path;
	var $weight;
	var $sumario;
	
	function Upload ($tempName='', $arq='', $path='', $mimeType='') {
		
		$this->tempName = $tempName;
		$this->path = $path;
		$this->mimeType = $mimeType;
		
		$retiraveis = array(' ', ',', ';', ':', '^', '~', '+', '=', '[', ']', '{', '}', '!', '@', '#', '$', '%', '&', '*', '(', ')', '/', '|', '?');
		$substitutos = array();
		
		for ($r=0; $r<count($retiraveis); ++$r) {
			$substitutos[] = '';
		}
		$this->arq = str_replace($retiraveis, $substitutos, $arq);
	}
	
	function definePrefixo($prefixo) {
		$this->arq = $prefixo . $this->arq;
	}
	
	function definePeso($weight) {
		$this->weight = $weight;
	}
	
	function retornaPeso($medida='Kb') {
		if ($medida == 'Kb') {
			$coef = 1024;
			$decimais = 2;
		}
		elseif ($medida == 'Mb') {
			$coef = 1048576;
			$decimais = 6;
		}
		else {
			$medida = 'bytes';
			$coef = 1;
			$decimais = 0;
		}
		
		$tamanho = ($this->weight) / $coef;
		$tamanho = number_format($tamanho, $decimais, ',', '.');
		
		if ($tamanho > 0) {
			$tamanho = $tamanho . ' ' . $medida;
		}
		else {
			$tamanho = 'n.d.';
		}
		return $tamanho;
	}
	
	function getArq () {
		return $this->arq;
	}
	
	function geraSumario() {
		$sumario = '
		<div class="mini">Sumário do Upload</div>
		<table align="center" cellpadding=1 cellspacing=2 width="100%">
			<tr class="ln1">
				<td align="right">Arquivo:&nbsp;</td>
				<td class="txt">' . $this->arq . '</td>
			</tr>
			<tr class="ln2">
				<td align="right">Tipo:&nbsp;</td>
				<td class="txt">' . $this->mimeType . '</td>
			</tr>
			<tr class="ln1">
				<td align="right">Destino:&nbsp;</td>
				<td class="txt">' . $this->path . '</td>
			</tr>
			<tr class="ln2">
				<td align="right">Peso:&nbsp;</td>
				<td class="txt">' . number_format(($this->weight / 1024), 2, ',', '.') . ' Kb</td>
			</tr>
		</table>
		';
		$this->sumario = $sumario;
		return $this->sumario;
	}

}

?>