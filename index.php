<?php 
error_reporting(0);
include_once "inc/header.php"; 
?>

<div id="conteudo">
	
	<?php
		$paginasPermitidas = array('home', 'cadastrar', 'score', 'jogar', 'perde');
		if($_GET['pagina'] == ''){
			include_once 'pages/home.php';
		}else if(in_array($_GET['pagina'], $paginasPermitidas)){
			include_once 'pages/'.$_GET['pagina'].'.php';
		}else{
			include_once 'pages/erro404.php';
		}
	?>
	
</div><!-- conteudo -->

<?php include_once "inc/footer.php"; ?>