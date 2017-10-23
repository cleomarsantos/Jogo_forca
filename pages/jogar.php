<?php
	//session_destroy();

	if(!isset($_SESSION['pontos']) || $_SESSION['pontos'] == 0){
		if(isset($_GET['pontos'])){
			$_SESSION['pontos'] = $_GET['pontos'];
		}else{
			$_SESSION['pontos'] = 0;	
		}
		
	}

	if(isset($_GET['erro'])){
		$_SESSION['erro'] = $_GET['erro'];
	}else if(!isset($_SESSION['erro'])){
		$_SESSION['erro'] = 0;
	}

	if($_SESSION['erro'] == 7){
		header("Location: http://localhost/jogodaforca/?pagina=perde");
	}

	if(!is_array($_SESSION['letra-certa'])){
		$_SESSION['letra-certa'] = array();
	}
	if(!is_array($_SESSION['letra-errada'])){
		$_SESSION['letra-errada'] = array();
	}

	(is_array($_SESSION['palavra-1']))? $palavra1 = current($_SESSION['palavra-1']) : '';
	(is_array($_SESSION['palavra-2']))? $palavra2 = current($_SESSION['palavra-2']) : '';
	(is_array($_SESSION['palavra-3']))? $palavra3 = current($_SESSION['palavra-3']) : '';

	if(isset($_GET['letra']) && (strstr($palavra1, $_GET['letra']) || strstr($palavra2, $_GET['letra']) || strstr($palavra3, $_GET['letra']))){ 
		if(!in_array($_GET['letra'], $_SESSION['letra-certa'])){
			$_SESSION['letra-certa'][] = $_GET['letra'];
		}
	}

	if(isset($_GET['letra']) && !in_array($_GET['letra'], $_SESSION['letra-certa'])){
		if(!in_array($_GET['letra'], $_SESSION['letra-errada'])){
			$_SESSION['letra-errada'][] = $_GET['letra'];
			$_SESSION['erro'] = $_SESSION['erro'] + 1;
			echo "<meta HTTP-EQUIV='refresh' CONTENT='0'>";
		}
	}

	//var_dump($_SESSION);

	if(!isset($_SESSION['tema'])){
		$sqlTema = "SELECT * FROM tema ORDER BY RAND() LIMIT 1";
		$executaTema = BD::conn()->prepare($sqlTema);
		$executaTema->execute();
		$tema = $executaTema->fetchObject();
		$_SESSION['tema'] = $tema->tema;



		$sqlTexto = "SELECT * FROM palavra WHERE id_tema = ? ORDER BY RAND() LIMIT 3";
		$executaTexto = BD::conn()->prepare($sqlTexto);
		$executaTexto->execute(array($tema->id));
		$i = 0;
		if($executaTexto->rowCount() > 2){
			while($texto = $executaTexto->fetchObject()){
				$i++;
				$tamanho = strlen(trim($texto->texto));
				$_SESSION['palavra-'.$i][$tamanho] = $texto->texto;
			}
		}else{
			echo '<p id="aviso">Não existem palavras/frases suficientes neste tema';
		}
	}

	//verificando se as palavras estão completas
	if($_SESSION['letra-certa'] != null){
		//palavra 1
		$p1ok = str_replace(" ", "", $palavra1);
		$tp1 = strlen($p1ok);

		if(!isset($_SESSION['r1']) || $_SESSION['r1'] == 0){
			$_SESSION['r1'] = 1;
		}

		if($_SESSION['r1'] == 0 || $_SESSION['r1'] == 1){
			for($i=0;$i < $tp1;$i++){
				if(!in_array($p1ok[$i], $_SESSION['letra-certa'])){
					$_SESSION['r1'] = 0;
				}
			}
			if($_SESSION['r1'] == 1){
				$_SESSION['r1'] = 2;
				$_SESSION['pontos'] = $_SESSION['pontos'] + 100;
				echo "<meta HTTP-EQUIV='refresh' CONTENT='0'>";
			}
		}

		//palavra 2
		$p2ok = str_replace(" ", "", $palavra2);
		$tp2 = strlen($p2ok);
		
		if(!isset($_SESSION['r2']) || $_SESSION['r2'] == 0){
			$_SESSION['r2'] = 1;
		}

		if($_SESSION['r2'] == 0 || $_SESSION['r2'] == 1){
			for($i=0;$i < $tp2;$i++){
				if(!in_array($p2ok[$i], $_SESSION['letra-certa'])){
					$_SESSION['r2'] = 0;
				}
			}

			if($_SESSION['r2'] == 1){
				$_SESSION['r2'] = 2;
				$_SESSION['pontos'] = $_SESSION['pontos'] + 100;
				echo "<meta HTTP-EQUIV='refresh' CONTENT='0'>";
			}
		}

		//palavra 3
		$p3ok = str_replace(" ", "", $palavra3);
		$tp3 = strlen($p3ok);
		
		if(!isset($_SESSION['r3']) || $_SESSION['r3'] == 0){
			$_SESSION['r3'] = 1;
		}

		if($_SESSION['r3'] == 0 || $_SESSION['r3'] == 1){
			for($i=0;$i < $tp3;$i++){
				if(!in_array($p3ok[$i], $_SESSION['letra-certa'])){
					$_SESSION['r3'] = 0;
				}
			}

			if($_SESSION['r3'] == 1){
				$_SESSION['r3'] = 2;
				$_SESSION['pontos'] = $_SESSION['pontos'] + 100;
				echo "<meta HTTP-EQUIV='refresh' CONTENT='0'>";
			}
		}


		$erro = $_SESSION['erro'];
		if($_SESSION['r1'] == 2 && $_SESSION['r2'] == 2 && $_SESSION['r3'] == 2){
			$pontos = $_SESSION['pontos'];
			session_unset($_SESSION['tema']);
			header("Location: http://localhost/jogodaforca/?pagina=jogar&erro=".$erro."&pontos=".$pontos);
		}
	}


?>
<h1 class="tema">CATEGORIA: <?php echo strtoupper($_SESSION['tema']);?></h1>
<div id="forca">
	<img class="imagem" src="<?php echo PATH;?>/imagens/erro-<?php echo $_SESSION['erro']; ?>.png" />
</div>
<div id="palavras">
	<span class="p1">
		<?php 
			$p1 = "";
			foreach($_SESSION['palavra-1'] as $id => $valor){
				for($i=0;$i < $id; $i++){
					if($valor[$i] == ' '){
						$p1 .= " ";
					}else if(in_array($valor[$i], $_SESSION['letra-certa'])){
						$p1 .= $valor[$i];
					}else{
						$p1 .= "_";
					}
				}
			}
			echo $p1;
		?>
	</span>
	<span class="p2">
		<?php 
			$p2 = "";
			foreach($_SESSION['palavra-2'] as $id => $valor){
				for($i=0;$i < $id; $i++){
					if($valor[$i] == ' '){
						$p2 .= " ";
					}else if(in_array($valor[$i], $_SESSION['letra-certa'])){
						$p2 .= $valor[$i];
					}else{
						$p2 .= "_";
					}
				}
			}
			echo $p2;
		?>
	</span>
	<span class="p3">
		<?php 
			$p3 = "";
			foreach($_SESSION['palavra-3'] as $id => $valor){
				for($i=0;$i < $id; $i++){
					if($valor[$i] == ' '){
						$p3 .= " ";
					}else if(in_array($valor[$i], $_SESSION['letra-certa'])){
						$p3 .= $valor[$i];
					}else{
						$p3 .= "_";
					}
				}
			}
			echo $p3;
		?>
	</span>
</div><!-- palavras -->

<div id="teclado">
	<ul>
		<li><button onclick="?pagina=jogar&letra=Q" class="btn <?php echo $site->inSession('Q',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="Q">Q</button></li>
		<li><button onclick="?pagina=jogar&letra=W" class="btn <?php echo $site->inSession('W',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="W">W</button></li>
		<li><button onclick="?pagina=jogar&letra=E" class="btn <?php echo $site->inSession('E',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="E">E</button></li>
		<li><button onclick="?pagina=jogar&letra=R" class="btn <?php echo $site->inSession('R',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="R">R</button></li>
		<li><button onclick="?pagina=jogar&letra=T" class="btn <?php echo $site->inSession('T',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="T">T</button></li>
		<li><button onclick="?pagina=jogar&letra=Y" class="btn <?php echo $site->inSession('Y',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="Y">Y</button></li>
		<li><button onclick="?pagina=jogar&letra=U" class="btn <?php echo $site->inSession('U',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="U">U</button></li>
		<li><button onclick="?pagina=jogar&letra=I" class="btn <?php echo $site->inSession('I',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="I">I</button></li>
		<li><button onclick="?pagina=jogar&letra=O" class="btn <?php echo $site->inSession('O',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="O">O</button></li>
		<li><button onclick="?pagina=jogar&letra=P" class="btn <?php echo $site->inSession('P',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="P">P</button></li>
	</ul>

	<ul>
		<li><button onclick="?pagina=jogar&letra=A" class="btn <?php echo $site->inSession('A',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="A">A</button></li>
		<li><button onclick="?pagina=jogar&letra=S" class="btn <?php echo $site->inSession('S',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="S">S</button></li>
		<li><button onclick="?pagina=jogar&letra=D" class="btn <?php echo $site->inSession('D',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="D">D</button></li>
		<li><button onclick="?pagina=jogar&letra=F" class="btn <?php echo $site->inSession('F',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="F">F</button></li>
		<li><button onclick="?pagina=jogar&letra=G" class="btn <?php echo $site->inSession('G',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="G">G</button></li>
		<li><button onclick="?pagina=jogar&letra=H" class="btn <?php echo $site->inSession('H',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="H">H</button></li>
		<li><button onclick="?pagina=jogar&letra=J" class="btn <?php echo $site->inSession('J',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="J">J</button></li>
		<li><button onclick="?pagina=jogar&letra=K" class="btn <?php echo $site->inSession('K',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="K">K</button></li>
		<li><button onclick="?pagina=jogar&letra=L" class="btn <?php echo $site->inSession('L',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="L">L</button></li>
	</ul>
	<ul>
		<li><button onclick="?pagina=jogar&letra=Z" class="btn <?php echo $site->inSession('Z',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="Z">Z</button></li>
		<li><button onclick="?pagina=jogar&letra=X" class="btn <?php echo $site->inSession('X',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="X">X</button></li>
		<li><button onclick="?pagina=jogar&letra=C" class="btn <?php echo $site->inSession('C',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="C">C</button></li>
		<li><button onclick="?pagina=jogar&letra=V" class="btn <?php echo $site->inSession('V',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="V">V</button></li>
		<li><button onclick="?pagina=jogar&letra=B" class="btn <?php echo $site->inSession('B',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="B">B</button></li>
		<li><button onclick="?pagina=jogar&letra=N" class="btn <?php echo $site->inSession('N',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="N">N</button></li>
		<li><button onclick="?pagina=jogar&letra=M" class="btn <?php echo $site->inSession('M',$_SESSION['letra-certa'], $_SESSION['letra-errada']);?>" value="M">M</button></li>
	</ul>
</div><!-- teclado -->
