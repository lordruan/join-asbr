<?php 
	$postdata = file_get_contents('php://input');
	$request = json_decode($postdata);
	//print_r($request->regiao_id);
	if ($request->token = md5('joinasbr')){
		switch ($request->model) {
			case 'unidades':
				include 'ModelUnidades.php';
				$model = new ModelUnidades;
				break;
			case 'usuarios':
				include 'ModelUsuarios.php';
				$model = new ModelUsuarios;
				break;
		}
		switch ($request->metodo) {
			case 'all':
				echo $model->getAll();
				break;
			case 'regiaoid':
				echo $model->byRegiaoId($request->regiao_id);
				break;
			case 'inserir':
				echo $model->inserir($request->pessoa);
				break;
		}

	}
 ?>