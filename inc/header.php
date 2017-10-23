<?php
	session_start(); 
	include_once 'config.php';
	function __autoload($classe){
		require_once 'classes/'.$classe.'.class.php';
	}
	BD::conn();
	$site = new Site();

	if($_GET['voltar'] == '1'){
		session_destroy();
		header("Location: ".PATH);
	}
?>
<html>
<head>
	<meta charset="UTF-8">
	<title>Jogo da Forca</title>
	<link rel="stylesheet" type="text/css" href="css/style.css" media="screen">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/funcoes.js"></script>
</head>
<body>
	<div id="box">
		<h1 class="header">JOGO DA FORCA<?php echo (isset($_GET['pagina']) && $_GET['pagina'] != 'perde') ? '<a href="'.PATH.'?voltar=1" class="voltar">Voltar</a>' : ''; ?></h1>
