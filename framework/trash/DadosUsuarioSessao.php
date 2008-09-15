<?php
// incorporada al sistema en 25/11/2006

// 2004-03-31 funcion desarrollada para retornar todos los datos
// del usuario dueno de la sesion informada
// pasa las siguientes informaciones:
// username: nombre de usuario
// fullname: Nombre completo del usuario
// email: direccion de e-mail
// empresa: la empresa donde trabaja
// cargo: su cargo en la empresa

function DadosUsuarioSessao($conexao, $sessao) {
	// constata conexao mysql
	if (is_resource($conexao) && strlen($sessao) > 0) {
		$sqlUsuarioSessao = "SELECT 
								usu.codusuario, 
								usu.nome,
								usu.usuario,  
								usu.email 
							FROM 
							`" . ATU_BD_TUSR . "` AS usu INNER JOIN 
							`" . ATU_BD_TSESS . "` AS sess ON 
								sess.codusuario=usu.codusuario 
						WHERE 
							sess.idsessao='" . $sessao . "' 
						LIMIT 0, 1";
		$trbUsuarioSessao = mysql_query($sqlUsuarioSessao, $conexao);
		if (@mysql_num_rows($trbUsuarioSessao) > 0) {
			$dadosUsuario = mysql_fetch_assoc($trbUsuarioSessao);
			@mysql_free_result($trbUsuarioSessao);
		} else {
			$dadosUsuario = $sqlUsuarioSessao;
		}
	}
	// falha conexao mysql
	else {
		$dadosUsuario = null;
	}
	return $dadosUsuario;
}
?>