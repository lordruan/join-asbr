<?php 
require_once 'database.php';

class ModelUsuarios
{
	public function getAll()
	{
		$model = new Database();
		$response = $model->getAll('usuarios');
		if ($response[0]){
			return json_encode($response[1]);
		}
		return json_encode($response[1]);
	}
	public function inserir($dados)
	{
		if (!empty($dados)){
			$insersao = self::tratarInsert($dados);
			$model = new Database();
			$response = $model->inserir('usuarios',$insersao[0],$insersao[1]);
			if ($response[0]){
				$sql = "Select * from pessoas where id = ".$response[1];
				$novousuario = $model->executar($sql);
				if ($novousuario[0]){
					return self::enviaEndPoint($novousuario[1][0]);
				}
			}
			return json_encode($response[1]);
		}
	}
	private function tratarInsert($dados='')
	{
		$campos = [
			"`nome`",
			"`email`",
			"`data_nascimento`",
			"`telefone`",
			"`unidade_id`",
			"`score`",
		];		
		$valores =array();
		$valores[] = "'".$dados->nome."'";
		$valores[] = "'".$dados->email."'";
		$valores[] = "'".$dados->data_nascimento."'";
		$valores[] = "'".$dados->telefone."'";
		$valores[] = "'".$dados->unidade->id."'";	
		$pontuacao = self::calculaPontuacao($dados);
		$valores[] = "'".$pontuacao."'";
		return [self::preparaValores($campos),self::preparaValores($valores),$pontuacao];
	}
	private function calculaPontuacao($dados)
	{
		$pontuacao = 10;
		$pontuacao += $dados->unidade->pontuacao;
		$datahoje = '01/11/2016';
		$datahoje = self::tratarData($datahoje);
	    $diahj = ($datahoje[0]);
	    $meshj = ($datahoje[1]);
	    $anohj = ($datahoje[2]);
		$data_nascimento = self::tratarDateHtml($dados->data_nascimento);
	    $dia_nasc = ($data_nascimento[2]);
	    $mes_nasc = ($data_nascimento[1]);
	    $ano_nasc = ($data_nascimento[0]);
	    $idade = $anohj - $ano_nasc;
	    if ($meshj < $mes_nasc){
	    	$idade--;
	    }elseif ($meshj == $mes_nasc && $diahj <= $dia_nasc){
	    	$idade--;
	    }
	    if($idade >= 40 && $idade < 100){
	    	$pontuacao -= 3;
		}
		if ($idade < 18 || $idade >= 100) {
	    	$pontuacao -= 5;
		}
		return $pontuacao;
	}
	private function preparaValores($dados)
    {
        return implode(',', $dados);
    }
    private function tratarData($data)
    {
    	return explode('/', $data);
    }
    public function tratarDateHtml($dados)
	{
		$dados_array = explode('T', $dados);
		return explode('-', $dados_array[0]);
	}
	private function enviaEndPoint($dados)
	{
		$postdata = [
			'nome'=> $dados->nome,
			'email'=> $dados->email,
			'telefone'=> $dados->telefone,
			'data_nascimento'=> $dados->data_nascimento,
			'regiao'=> $dados->regiao,
			'unidade'=> $dados->unidade,
			'score'=> $dados->score,
			'token'=> 'a25637559aae35328a269e024c020ef8'
		];
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, 'http://api.actualsales.com.br/join-asbr/ti/lead');
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postdata));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		$retorno = curl_exec($curl);
		curl_close($curl);
		return $retorno;

	}

}