<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>Exemplos RAP</title>
</head>
<body>

<?php

	/**
	 * Criando uma declaração de RDF e imprimindo na tela em HTML
	 */
	include_once ("../../env/env.php");
	include(RDFAPI_INCLUDE_DIR . "RdfAPI.php");

	//Criando um statent(declaração)
	$someDoc = new Resource("http://www.prestesmachado.com.br/documento.html");
	$creator = new Resource("http://www.purl.org/dc/elements/1.1/creator");
	$statement1 = new Statement ($someDoc, $creator, new Literal ("Rodrigo Prestes Machado"));
	
	//Criando um modelo
	$model1 = ModelFactory::getDefaultModel();
	$model1->add($statement1);
	
	//imprimindo um modelo em html
	$model1->writeAsHtmlTable();
	
	//terminando um modelo
	$model1->close(); 

?>
</body>
</html>
