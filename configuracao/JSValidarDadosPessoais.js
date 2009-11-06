


function compararSenhas(senha1, senha2)
{
	if (senha1.value.length > 0 && senha1.value.length < 4)
	{
		alert('A senha informada deve conter 4 dígitos ou mais');
		senha1.focus();
		return false;
	}
	else if (senha1.value.length >= 4 || senha2.value.lenght >= 4)
	{
		if (senha1.value.length != senha2.value.length)
		{
			alert('Ao informar a senha para alteração,\ndeve-se digitar a mesma duas vezes');
			senha1.value = '';
			senha2.value = '';
			senha1.focus();
			return false;
		}
	}
	return true;
}

function validarEmail(mail)
{
	var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
	if (er.test(mail))
	{
		return true;
	}
	else
	{
		return false;
	}
}

function validarDadosPessoais(form)
{
	var validados = true;
	var nomeCompleto = document.getElementById('nomecompleto').value;
	if (nomeCompleto.length < 4)
	{
		alert('Nome deve possuir no mínimo 4 caracteres');
		return false;
	}
	if (nomeCompleto.indexOf(' ') < 0)
	{
		alert('O Nome deve ser informado completo.');
		return false;
	}

	if (validarEmail(document.getElementById('email').value))
	{
		if (compararSenhas(document.getElementById('senhausuario'), document.getElementById('repitasenha')))
		{
			form.submit();
		}
	}
	else
	{
		alert('E-mail inválido. Por favor revise.');
		document.getElementById('email').focus();
		return false;
	}
}