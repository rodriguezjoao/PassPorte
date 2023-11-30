<?php

$foto = $id.".jpg";
	$target_dir ='img/';
	$data = file_get_contents('php://input');


    if(!(file_put_contents($target_dir.$foto,$data) === FALSE)){
    $update = $conn->prepare("UPDATE usuarios SET foto=? WHERE id=?");
    $update->bindvalue(1,$foto);
    $update->bindvalue(2,$id);
    $update->execute();

    echo $foto;
	}

	 	