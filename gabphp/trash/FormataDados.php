<?
// Original do imobCIEL
// Incorporada ao swbadm em 11/01/2007
function FormataDados($dado)
{
	$dado = strtolower(strip_tags($dado));
	
	$originais = array('�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�', '�');
	$substitutos = array('c', 'n', 'a', 'e', 'i', 'o', 'u', 'a', 'o', 'o', 'c', 'n', 'a', 'e', 'i', 'o', 'u', 'a', 'o', 'o');

	$dado = str_replace($originais, $substitutos, $dado);

	$somenteLetras = array();
	for ($i = 97; $i <= 122; ++$i)
	{
		$somenteLetras[] = chr($i);
	}
	
	// Novo Dado inicializa vazio
	
	$novoDado = '';
	
	// Analisa cada caracter em busca dos v�lidos
	
	for ($i=0; $i<strlen($dado); ++$i)
	{
		$caracter = substr($dado, $i, 1);
		if (in_array($caracter, $somenteLetras))
		{
			$novoDado .= $caracter;
		}
	}
	return $novoDado;
}
?>