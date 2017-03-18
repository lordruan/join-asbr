<?php 
require_once 'database.php';

class ModelUnidades
{
	public function getAll()
	{
		$model = new Database();
		$response = $model->getAll('unidades');
		if ($response[0]){
			return json_encode($response[1]);
		}
		return json_encode($response[1]);
	}
	public function byRegiaoId($regiaoid='')
	{
		$model = new Database();
		$sql = "Select id, nome, pontuacao from unidades where regiao_id = $regiaoid";
		$response = $model->executar($sql);
		if ($response[0]){
			return json_encode($response[1]);
		}
		return json_encode($response[1]);
	}
}