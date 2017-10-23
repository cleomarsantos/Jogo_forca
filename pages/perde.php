<?php
	
	/*echo "<pre>";
	echo print_r($_SESSION);
	echo "</pre>";
	*/
	$pontos = 0;

	//removendo espaços
	if(isset($_SESSION['palavra-1'])){
		$_SESSION['palavra-1'] = str_replace(" ", "", $_SESSION['palavra-1']);
	}

	if(isset($_SESSION['palavra-2'])){
		$_SESSION['palavra-2'] = str_replace(" ", "", $_SESSION['palavra-2']);
	}

	if(isset($_SESSION['palavra-3'])){
		$_SESSION['palavra-3'] = str_replace(" ", "", $_SESSION['palavra-3']);
	}

	//esvaziando sessões com palavra certa
	if($_SESSION['r1'] == 2){
		unset($_SESSION['palavra-1']);
	}else{
		$palavra1 = current($_SESSION['palavra-1']);
		$tam1 = strlen($palavra1);
	}

	if($_SESSION['r2'] == 2){
		unset($_SESSION['palavra-2']);
	}else{
		$palavra2 = current($_SESSION['palavra-2']);
		$tam2 = strlen($palavra2);
	}

	if($_SESSION['r3'] == 2){
		unset($_SESSION['palavra-3']);
	}else{
		$palavra3 = current($_SESSION['palavra-3']);
		$tam3 = strlen($palavra3);
	}

	if($tam1 != ''){
		for($i=0;$i<$tam1;$i++){
			if(in_array($palavra1[$i], $_SESSION['letra-certa'])){
				$pontos = $pontos + 15;
			}
		}
	}

	if($tam2 != ''){
		for($i=0;$i<$tam2;$i++){
			if(in_array($palavra2[$i], $_SESSION['letra-certa'])){
				$pontos = $pontos + 15;
			}
		}
	}

	if($tam3 != ''){
		for($i=0;$i<$tam3;$i++){
			if(in_array($palavra3[$i], $_SESSION['letra-certa'])){
				$pontos = $pontos + 15;
			}
		}
	}
	
	$_SESSION['pontos'] = $_SESSION['pontos'] + $pontos;

	if(isset($_POST['cadastrar']) && $_POST['nome'] != ''){
		$_SESSION['pontos'] = $_SESSION['pontos'] - $pontos;
		$dados = array(
		'jogador' => $_POST['nome'],
		'pontos' => $_SESSION['pontos']
		);

		if($site->inserir('score', $dados)){
			session_destroy();	
			echo "<script>alert('Cadastro efetuado com sucesso');</script>";
			header("Location: http://localhost/jogodaforca/?pagina=score");	
		}else{
			echo "<script>alert('Falha ao cadastrar registro');</script>";
		}
	}else if(isset($_POST['cadastrar']) && $_POST['nome'] == ''){
		echo "<script>alert('Você precisa digitar um nome.');</script>";		
	}



?>
<div id="inicio-botoes">
	<form method="post" action="" name="form-pontos">
		<span class="pontos">Você Fez <?php echo $_SESSION['pontos']; ?> Pontos</span>
		<label>
			Digite seu nome
		</label>
		<input type="text" name="nome" id="campo-nome"/>
		<input type="submit" name="cadastrar" class="botao-input" value="Cadastrar" />
	</form>
</div><!-- inicio-botoes -->