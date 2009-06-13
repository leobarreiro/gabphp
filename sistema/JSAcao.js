
function CarregaFuncionalidadesModulo(codModulo) {
	
	var url = 'AJFuncionalidadesSelect.php';
	var dados = 'codmodulo=' + codModulo;
	var campo = 'funcionalidade';
	
	Atualiza = new RequisicaoAjax(url, dados, campo);
	Atualiza.realizaRequisicao();
	
}
