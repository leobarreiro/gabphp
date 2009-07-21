<?php
/*
renArquivos.class.php
Renomeia Arquivos de um diretorio especificado pelo usuario
*/

class ManArquivos {

var $dir;
var $dirDest;
var $metd;
var $sep;
var $det;
var $lido;
var $arquivos;
var $qtd;
var $novosArquivos;
var $qtdCp;
var $qtdRen;
var $separador;

function ManArquivos($dir, $dirDest, $metd, $sep='.')
{
	if (is_string($dir) && file_exists($dir) && is_dir($dir))
	{
		$this->dir = $dir;
		$this->dirDest = $dirDest;
		$this->separador = $sep;
		
		
		$this->metd = $metd;
		$abreDir = opendir($dir);
		$arquivos = array();
		while (false !== ($arq = readdir($abreDir)))
		{
			if ($arq != '.' && $arq != '..')
			{
				$arquivos[] = $arq;
			}
		}
		closedir($abreDir);
		sort($arquivos);
		if (count($arquivos) > 0)
		{
			$renomeia = true;
			$this->arquivos = $arquivos;
			$this->lido = true;
			$this->qtd = count($arquivos);
			$this->det = 'Diret�rio Lido corretamente.';
		}
		else
		{
			$renomeia = false;
			$this->arquivos = array();
			$this->novosarquivos = array();
			$this->lido = true;
			$this->qtd = 0;
			$this->det = 'Diret�rio Lido corretamente mas nenhum arquivo foi encontrado.';
		}
		
		if ($renomeia)
		{
			$novosArquivos = array();
			$qtdRen = 0;
			switch ($metd) {
				case 'dt'; // data de cria��o
					$qtdRen = 0;
					foreach ($arquivos as $arqv)
					{
						$nomeOriginal = $dir . $arqv;
						$extensao = substr($arqv, (strrpos($arqv, '.')));
						$sep = $this->separador;
						$formatoData = "y" . $sep . "m" . $sep . "d";
						$novoNome = date($formatoData, @filemtime($dir . $arqv));
						$sufixo = 97;
						$nomeComposto = $novoNome . chr($sufixo) . $extensao;
						while (in_array($nomeComposto, $novosArquivos))
						{
							++$sufixo;
							$nomeComposto = $novoNome . chr($sufixo) . $extensao;
						}
						$novosArquivos[] = $nomeComposto;
						clearstatcache($novoNome);
						unset($nomeComposto, $nomeOriginal, $extensao, $novoNome, $sufixo);
					}
					break;
				default: case 'dthora'; // data e hora de cria��o
					$qtdRen = 0;
					foreach ($arquivos as $arqv)
					{
						$nomeOriginal = $dir . $arqv;
						$extensao = substr($arqv, (strrpos($arqv, '.')));
						$sep = $this->separador;
						$formatoData = "y" . $sep . "m" . $sep . "d" . $sep . "H" . $sep . "i";
						$novoNome = date($formatoData, @filemtime($dir . $arqv));
						$sufixo = 97;
						$nomeComposto = $novoNome . chr($sufixo) . $extensao;
						while (in_array($nomeComposto, $novosArquivos))
						{
							++$sufixo;
							$nomeComposto = $novoNome . chr($sufixo) . $extensao;
						}
						$novosArquivos[] = $nomeComposto;
						clearstatcache($novoNome);
						unset($nomeComposto, $nomeOriginal, $extensao, $novoNome, $sufixo);
					}
					break;
			}
			$this->novosArquivos = $novosArquivos;
		}
	}
	else
	{
		$this->dir = null;
		$this->arquivos = null;
		$this->novosarquivos = null;
		$this->lido = false;
		$this->qtd = 0;
		$this->det = 'Diret�rio n�o v�lido ou inexistente.';
	}
}

function CopiaArquivos()
{
	$qtdCp = 0;
	if (count($this->novosArquivos) == count($this->arquivos))
	{
		$originais = $this->arquivos;
		$novos = $this->novosArquivos;
		$dir = $this->dir;
		$dirDest = $this->dirDest;
		for ($e=0; $e<count($novos); ++$e)
		{
			$nomeVelho = $dir . $originais[$e];
			$nomeNovo = $dirDest . $novos[$e];
			if (copy($nomeVelho, $nomeNovo))
			{
				++$qtdCp;
			}
		}
	}
	else
	{
		$this->det .= ' Quantidades de arquivos originais e arquivos novos s�o diferentes.';
	}
	$this->qtdCp = $qtdCp;
	return $qtdCp;
}

function RenomeiaArquivos()
{
	$qtdRen = 0;
	if (count($this->novosArquivos) == count($this->arquivos))
	{
		$originais = $this->arquivos;
		$novos = $this->novosArquivos;
		$dir = $this->dir;
		$dirDest = $this->dirDest;
		
		for ($e=0; $e<count($novos); ++$e)
		{
			$nomeVelho = $dir . $originais[$e];
			$nomeNovo = $dirDest . $novos[$e];
			if (rename($nomeVelho, $nomeNovo))
			{
				++$qtdRen;
			}
		}
	}
	else
	{
		$this->det .= ' Quantidades de arquivos originais e arquivos novos s�o diferentes.';
	}
	$this->qtdRen = $qtdRen;
	return $qtdRen;
}

function MudaDono($dono)
{
	if (count($this->novosArquivos) > 0)
	{
		$novos = $this->novosArquivos;
		$dirDest = $this->dirDest;
		
		for ($e=0; $e<count($novos); ++$e)
		{
			$nomeNovo = $dirDest . $novos[$e];
			@chown($nomeNovo, $dono);
		}
	}
}

function MudaPermissoes($permissoes)
{
	if (count($this->novosArquivos) > 0)
	{
		while(strlen($permissoes) < 4)
		{
			$permissoes = 0 . $permissoes;
		}
		$novos = $this->novosArquivos;
		$dirDest = $this->dirDest;
		
		for ($e=0; $e<count($novos); ++$e)
		{
			$nomeNovo = $dirDest . $novos[$e];
			@chmod($nomeNovo, $permissoes);
		}
	}
}

function RetornaDet()
	{
		return $this->det;
	}


}

?>