<!DOCTYPE html>
<html>

<head>

	<?php
		session_start();
		if (!isset($_SESSION['usuario'])) {
			header('Location:login.html');
		}else{
			$usuario = $_SESSION['usuario'];
		}

		include("conexao/conexao.php");
		$Obj_Conexao = new CONEXAO();
		
	?>

	<title>Home - Fair</title>
	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

	<!-- Linkando os icones -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ"
	 crossorigin="anonymous">

	<!-- Linkando o css -->
	<link rel="stylesheet" type="text/css" href="css/index.css">

	<!-- Linkando os scripts -->
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/index.js"></script>
</head>

<body>
	<center>

		<h1>Bem vindo ao Fair</h1>
		<h2 id="titulo_pagina"></h2>
		<h2>Usuario id:
			<?= $_SESSION['usuario'] ?>
		</h2>

		<div class="w3-content w3-section" style="max-width:500px">
			<div class="mySlides w3-animate-right div_elementos" id="meus_eventos">
				<h2> Meus eventos </h2>
				<label class="eventos">
				</label>
				<hr>
				<input type="text" id="nome_evento" placeholder='Nome do evento' name="">
				<span class="spacing-horizontal"></span>
				<button id="btn_add_evento">ADICIONAR EVENTO</button><br><br>
				<p id="retorno_evento"></p>
			</div>

			<div class="mySlides w3-animate-right div_elementos" id="meus_produtos">
				<h2 id="titulo_evento"></h2>
				<div class="produtos">
				</div>
				<input type="hidden" id="evento_id">
				<hr>
				<input type="text" id="nome_produto" placeholder="Nome do produto" name="">
				<span class="spacing-horizontal"></span>
				<button id="btn_add_produto">ADICIONAR PRODUTO</button>
				<br>
				<hr>
				<p id="retorno_produto"></p>
				<button id="voltar_evento" class="spacing-vertical">Voltar</button><br>
			</div>

			<div class="mySlides w3-animate-right div_elementos" id="produto_pessoas">
				<h2 id="titulo_produto"></h2>
				<div class="pessoas">
				</div>
				<input type="hidden" id="produto_id">
				<hr>
				<input type="text" id="nome_pessoa" placeholder="Nome da pessoa" name="">
				<span class="spacing-horizontal"></span>
				<button id="btn_add_pessoa">ADICIONAR PESSOA</button>
				<br><br>
				<p id="retorno_pessoa"></p>
				<button id="voltar_produto" class="spacing-vertical">Voltar</button><br>
			</div>
			<br>
			<a href="funcoes/funcoes.php?funcao=sair">Sair</a>
		</div>
	</center>
</body>

</html>