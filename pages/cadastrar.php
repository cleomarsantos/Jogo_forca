<?php
	session_destroy();	
	$isAcao = false;

	if(isset($_GET['acao']) && $_GET['acao'] != ''){
		$isAcao = true;
	}else{
		$isAcao = false;
		if(isset($_POST['cadastrar'])){
			echo "<script>alert('Selecione um tipo de cadastro');</script>";
		}
	}

	if(isset($_POST['cadastrar'])){
		if($_POST['tema'] == ''){
			echo "<script>alert('Selecione um tema para poder cadastrar');</script>";
		}else{
			if(strlen($_POST['cadastro']) < 2 || $site->registroExistente($_POST['cadastro'])){
				echo "<script>alert('".$_GET['acao']." já esta cadastrada no sistema ou possui menos de dois caracteres');</script>";
			}else{
				$registro = strtoupper($_POST['cadastro']);
				if($_GET['acao'] == 'palavra'){
					$tipo = 'p';
				}else if($_GET['acao'] == 'frase'){
					$tipo = 'f';
				}

				if($_GET['acao'] == 'palavra' && strstr($_POST['cadastro'], " ")){
					echo "<script>alert('Não insira espaços ao cadastrar palavras');</script>";
				}else if($_GET['acao'] == 'frase' && !strstr($_POST['cadastro'], " ")){
					echo "<script>alert('A frase deve possuir espaço entre as palavras');</script>";
				}else{	
					$dados = array(
					'id_tema' => $_POST['tema'],
					'texto' => $registro,
					'tipo' => $tipo
					);

					if($site->inserir('palavra', $dados)){
						echo "<script>alert('Cadastro efetuado com sucesso');</script>";	
					}else{
						echo "<script>alert('Falha ao cadastrar registro');</script>";	
					}
				}

			}
		}
	}
?>
<div id="geral">
	<div id="esquerda">
		<a href="<?php echo PATH?>/?pagina=cadastrar&acao=palavra" class="botao">CADASTRAR PALAVRA</a>
	</div><!-- esquerda -->
		
	<div id="direita">
		<a href="<?php echo PATH?>/?pagina=cadastrar&acao=frase" class="botao">CADASTRAR FRASE</a>
	</div><!-- direita -->


	<form name="formCadastro" method="post" action="">
		
		<?php
			$SQLtema = "SELECT * FROM tema";
			$executaTema = BD::conn()->prepare($SQLtema);
			$executaTema->execute();
		?>
		<select name="tema" class="dropdown">
			<option value="">TEMA</option>
			<?php
			while($tema = $executaTema->fetchObject()){ ?>
				<option value="<?php echo $tema->id;?>" <?php echo ($_POST['tema'] == $tema->id)? 'selected="selected"' : '';?>><?php echo $tema->tema; ?></option>
			<?php } ?>
		</select>
		<input type="text" name="cadastro" id="cadastro" class="campo-cadastro <?php echo ($isAcao)? 'branco' : 'cinza';?>" <?php echo ($isAcao)? '' : 'disabled="disabled"';?>maxlength="30" >
		<input type="submit" name="cadastrar" value="CADASTRAR" class="botao-input left">
		<input type="reset" value="LIMPAR" class="botao-input right">
	</form>
</div><!-- geral -->