<div id="inicio-botoes" class="score">
<h1 class="titulo"> Ranking 10+ </h1>
<table border="1" cellpadding="0" cellspacing="0" class="carrinho">
	<thead>
		<tr>
			<th>Jogador</th>
			<th>Pontos</th>
		</tr>
	</thead>
	<tbody>
	<?php
		session_destroy();	
		$SQL= "SELECT * FROM score ORDER BY pontos DESC LIMIT 10";
		$executaScore = BD::conn()->prepare($SQL);
		$executaScore->execute();

		if($executaScore->RowCount() == 0){
			echo "<tr><td colspan='2'><center>Nenhum score encontrado</center></td></tr>";
		}else{
			while($score = $executaScore->fetchObject()){ 
			?>
				<tr>
					<td><?php echo $score->jogador; ?></td>
					<td><?php echo $score->pontos; ?></td>
				</tr>
	<?php }}?>
	</tbody>
</table>
</div> <! -- inicio-botoes -->