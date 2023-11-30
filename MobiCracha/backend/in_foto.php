<?php 

    if(isset($_FILES["imagem"]["tmp_name"])){

        $foto = $_POST['foto'];
        $local = "../backend/img/$foto";

        // move_uploaded_file($_FILES["imagem"]["tmp_name"], $local);
    

        $largura = "200";
	
        $imagem_temporaria = imagecreatefromjpeg($_FILES['imagem']['tmp_name']);
        $largura_original = imagesx($imagem_temporaria);
        $altura_original = imagesy($imagem_temporaria);
        $nova_altura = round($largura / $largura_original * $altura_original); 
        $imagem_redimensionada = imagecreatetruecolor($largura, $nova_altura);
        imagecopyresampled($imagem_redimensionada, $imagem_temporaria, 0, 0, 0, 0, $largura, $nova_altura, $largura_original, $altura_original);
        imagejpeg($imagem_redimensionada, "../backend/img/" . $foto);
			
        
        if ($foto != ""){
            if (file_exists('img/'.$foto)) {
            $diretorio = "img/"; 
            $caminho=$diretorio.$foto;
            $caminho_thumb='img/thumb_'.$foto;
            list($width, $height, $type) = getimagesize($caminho);
            $tipo_imagem = image_type_to_mime_type ($type);
            $new_width = 100;
            $new_height = 100;
            $image_p = imagecreatetruecolor($new_width, $new_height);
            if ($tipo_imagem == 'image/jpeg'){
            $image = imagecreatefromjpeg($caminho);
            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            imagejpeg($image_p, $caminho_thumb, -1);
            }
            // if ($tipo_imagem == 'image/png'){
            // $image = imagecreatefrompng($caminho);
            // imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            // imagepng($image_p, $caminho_thumb, 0); 
            // }
            // if ($tipo_imagem == 'image/gif'){
            // $image = imagecreatefromgif($caminho);
            // imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            // imagegif($image_p, $caminho_thumb); 
            // }
            imagedestroy($image_p);
            }
           }


    } else {
        return;
    }