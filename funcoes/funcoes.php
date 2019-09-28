<?php

	include("../conexao/conexao.php"); /* Incluindo o arquivo de conexão com o banco de dados */

	$Obj_Conexao = new CONEXAO(); /* Cria um objeto de conexão */

	session_start(); /* Inicia uma sessão */

	if (isset($_POST['funcao'])) {
	 	if ($_POST['funcao'] == 'cadastro') { /* Função de cadastro de usuários */
	 		/* Recebendo variáveis via POST */
	 		$nome = "";
	 		$sobrenome = "";
	 		$email = $_POST['email']; 
	 		$password = $_POST['senha'];
	 		/* Verificando se o usuário já existe */
	 		$query = $Obj_Conexao->Consulta("SELECT * FROM usuarios WHERE email = '$email'");

	 		if (mysqli_num_rows($query) == 1) {
	 			echo 0;	/* Retorno se usuário já existir */
	 		}else{
	 			/* Cadastrando o usuário no banco de dados */
	 			$query = $Obj_Conexao->Consulta("INSERT INTO usuarios VALUES(null,'$email','$nome','$sobrenome','$password')");
	 			echo 1; /* Retorno se o usuário for cadastro */
	 		}
	 	}else if ($_POST['funcao'] == 'login') { /* Função para fazer login */
	 		/* Recebendo variáveis via POST */
	 		$email = $_POST['email'];
	 		$password = $_POST['senha'];
	 		/* Verificando se as credenciais estão corretas */
	 		$query = $Obj_Conexao->Consulta("SELECT * FROM usuarios WHERE email = '$email' AND senha = '$password'");

	 		if (mysqli_num_rows($query) == 1) { /* Verificando se o banco retornou um usuário */
	 			/* Obtendo o id do usuário */
	 			$resultado = mysqli_fetch_assoc($query);
	 			/* Armazenando o id do usuário em um cookie */
	 			$_SESSION['usuario'] = $resultado['id']; 
	 			echo 1; /* Retornando confirmação de login */
	 		}else{
	 			/* Retorno se as credenciais estiverem incorretas */
	 			echo 'Usuário ou senha incorreto(s)!';
	 		}
	 	}else if ($_POST['funcao'] == 'verificar_usuario') { /* Função que verifica se o usuário existe */
	 		/* Recebendo variáveis via POST */
	 		$email = $_POST['email'];
	 		/* Verificando se o email está disponível */
	 		$query = $Obj_Conexao->Consulta("SELECT * FROM usuarios WHERE email = '$email'");

	 		if (mysqli_num_rows($query) == 1) {
	 			echo 0; /* Retorno se email não estiver disponível */
	 		}else{
	 			echo 1; /* Retorno se email estiver disponível */
	 		}
	 	}else if ($_POST['funcao'] == 'cadastrar_evento') { /* Função para cadastrar evento */
	 		$user = $_SESSION['usuario'];
	 		/* Recebendo variáveis via POST */
	 		$nome_evento = $_POST['nome_evento'];
	 		/* Verificando se o evento já existe */
	 		$query = $Obj_Conexao->Consulta("SELECT * FROM evento WHERE usuario_id = '$user' AND nome = '$nome_evento'");
	 		if (!$query || mysqli_num_rows($query) > 0) {
	 			echo 0;	/* Retorno se evento já existir */
	 		}else{
	 			/* Cadastrando evento no banco de dados */
	 			$query = $Obj_Conexao->Consulta("INSERT INTO evento VALUES(null,'$nome_evento','$user')");
	 			echo 1; /* Retorno se o evento for cadastrado */
	 		}
	 	}else if ($_POST['funcao'] == 'cadastrar_produto') {  /* Função para cadastrar um produto em determinado evento */
	 		/* Recebendo variáveis via POST */
	 		$evento_id = $_POST['evento_id'];
	 		$produto_nome = $_POST['produto_nome'];
	 		/* Verificando se o produto já existe */
	 		$query = $Obj_Conexao->Consulta("SELECT * FROM produto WHERE evento_id = $evento_id AND nome = '$produto_nome'");
	 		if (!$query || mysqli_num_rows($query) > 0) {
				echo 0; /* Retorno se o produto já existir */
	 		}else{
				/* Cadastrando o produto no banco de dados */
				$query = $Obj_Conexao->Consulta("INSERT INTO produto VALUES(null,'$produto_nome','$evento_id')");
				echo 1; /* Retorno se o produto foi cadastrado */
	 		}
	 	}else if ($_POST['funcao'] == 'cadastrar_pessoa') { /* Função para cadastrar uma pessoa em um determinado produto */
	 		/* Recebendo variáveis via POST */
	 		$produto_id = $_POST['produto_id'];
	 		$pessoa_nome = $_POST['pessoa_nome'];
	 		/* Verificando se a pessoa já está cadastrada no produto */
	 		$query = $Obj_Conexao->Consulta("SELECT * FROM pessoa WHERE produto_id = '$produto_id' AND nome = '$pessoa_nome'");
	 		if (!$query || mysqli_num_rows($query) > 0) {		
	 			echo 0; /* Retorno se a pessoa já estiver cadastrada */
	 		}else{
	 			/* Cadastrando a pessoa no banco de dados */
	 			$query = $Obj_Conexao->Consulta("INSERT INTO pessoa VALUES(null,'$pessoa_nome','$produto_id')");
	 			echo 1; /* Retorno se a pessoa for cadastrada */
	 		}
	 	}
 	}else if (isset($_GET['funcao'])) {
 		if ($_GET['funcao'] == 'obter_produtos'){ /* Função que busca os produtos de um determinado evento */
	 		$user = $_SESSION['usuario'];
	 		/* Recebendo variáveis via GET */
 			$evento_id = $_GET['evento_id'];
 			/* Pegando os produtos cadastrados no evento */
 			$query = $Obj_Conexao->Consulta("SELECT * FROM produto WHERE evento_id = $evento_id");
 			if (mysqli_num_rows($query) > 0) { /* Se existir algum produto no evento */
 				while ($linha = mysqli_fetch_assoc($query)){
	 				echo(json_encode($linha).'|'); /* Imprime uma linha JSON com informações do produto e um split('|') */
	 			}
 			}	 			
 		}else if ($_GET['funcao'] == 'obter_eventos'){ /* Função que busca os eventos de um usuário */
	 		$user = $_SESSION['usuario'];
	 		/* Pegando os eventos do usuário cadastrados no banco de dados */
 			$query = $Obj_Conexao->Consulta("SELECT * FROM evento WHERE usuario_id = '$user'");
 			if (mysqli_num_rows($query) > 0) { /* Se existir algum evento cadastrado */
 				while ($linha = mysqli_fetch_assoc($query)){
	 				echo(json_encode($linha).'|'); /* Imprime uma linha JSON com informações do evento e um split('|') */
	 			}
 			}	 			
 		}else if ($_GET['funcao'] == 'obter_pessoas'){ /* Função que busca as pessoas de um determinado produto */
 			/* Recebendo variáveis via GET */
	 		$produto_id = $_GET['produto_id'];
	 		/* Pegando as pessoas cadastradas no produto */
 			$query = $Obj_Conexao->Consulta("SELECT * FROM pessoa WHERE produto_id = $produto_id");
 			if (mysqli_num_rows($query) > 0) { /* Se existir alguma pessoa cadastrada no produto */
 				while ($linha = mysqli_fetch_assoc($query)){
	 				echo(json_encode($linha).'|'); /* Imprime uma linha JSON com informações da pessoa e um split('|') */
	 			}
	 			echo "{}";
 			}	 			
 		}else if ($_GET['funcao'] == 'sair'){ /* Função para fazer logout */
 			session_destroy(); /* Finaliza a sessão atual */
 			header("Location:../login.html"); /* Redireciona para a página de login */
 		}
 	}

?>