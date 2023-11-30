<?php
	
	// $user = 'id20661570_ric';
	// $pass = 'H3lip@23';
	// $db = 'id20661570_bdados';

	$user = 'root';
	$pass = '';
	$db = 'mobi';

	try{

        // $conn = new PDO('mysql:host=localhost;dbname=id20661570_bdados;charset=utf8', $user, $pass);
        $conn = new PDO('mysql:host=localhost;dbname=mobi;charset=utf8', $user, $pass);

        //echo "Conexão com sucesso";
        return $conn;
	}catch( PDOException $e ){
        echo "Erro ao conectar banco de dados: ".$e->getMessage();
        exit();
	}