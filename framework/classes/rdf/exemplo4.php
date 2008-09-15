<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>Exemplos RAP</title>
</head>
<body>

<?php

	/**
	 * Criando uma declara��o de RDF e salvando no banco de dados
	 */	

	include_once ("../../env/env.php");
	include(RDFAPI_INCLUDE_DIR . "RdfAPI.php");

	$mysql_database = ModelFactory::getDbStore(
	 											'MySQL', 
	 											'localhost', 
	 											'social', 
	 											'socialUser', 
	 											'socialPass'
	 											);
	
	$modelURI = "http://www.prestesmachado.com.br/exemplos/DbModel1";
	$dbModel1 = $mysql_database->getNewModel($modelURI);	 											

	
	//Criando um statent(declara��o)
	$someDoc = new Resource("http://www.prestesmachado.com.br/documento.html");
	$creator = new Resource("http://www.purl.org/dc/elements/1.1/creator");
	$statement1 = new Statement ($someDoc, $creator, new Literal ("Rodrigo Prestes Machado"));
	
	$dbModel1->add($statement1);
	
	echo "Se voc� criou o banco de dados e executou este c�digo; 
	ent�o a declara��o acima deve estar na tabela statements";
	
	
	
?>
</body>
</html>
