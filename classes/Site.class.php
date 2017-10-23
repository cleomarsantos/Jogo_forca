<?php
class Site extends BD{

	public function registroExistente($valor){
		$registro = strtoupper($valor);

		$reg = "SELECT * FROM palavra WHERE texto = ?";
		$executarReg = self::conn()->prepare($reg);
		$executarReg->execute(array($registro));

		if($executarReg->rowCount() != 0){
			return true;
		}else{
			return false;
		}	

	}

	public function inserir($tabela, $dados){
		$pegarCampos = array_keys($dados);
		$contarCampos = count($pegarCampos);
		$pegarValores = array_values($dados);
		$contarValores = count($pegarValores);

		$sql = "INSERT INTO $tabela (";
		if($contarCampos == $contarValores){
			foreach($pegarCampos as $campo){
				$sql .= $campo.', ';
			}
			
			$sql = substr_replace($sql, ")", -2, 1);
			$sql .= "VALUES (";
			
			for($i = 0;$i < $contarValores; $i++){
				$sql .= "?, ";
				$i;
			}

			$sql = substr_replace($sql, ")", -2, 1);
		}else{
			return false;
		}

		try{
			$inserir = self::conn()->prepare($sql);
			if($inserir->execute($pegarValores)){
				return true;	
			}else{
				return false;
			}
		}catch(PDOException $e){
			return false;
		}
	}
	

	public function inSession($valor, $session1, $session2){
		$classe = "";
		if(in_array($valor, $session1)){
			$classe = "success";
		}

		if(in_array($valor, $session2)){
			$classe = "danger";
		}
		return $classe;
	}	
}