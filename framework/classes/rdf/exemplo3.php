<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
	<title>Exemplos RAP</title>
</head>
<body>

<?php

	/**
	 * Criando as tabelas do banco de dados MySQL
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
	
	$mysql_database->createTables('MySQL');											


?>
</body>
</html>
