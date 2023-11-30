<?php

include_once("conexao.php");

$id = $_POST['id'];
$nome = $_POST['nome'];
$idade = $_POST['idade'];
$foto = $_POST['foto']??""; // nome da nova imagem se houver
$foto_velha = $_POST['foto_old']??""; // nome da imagem antiga

if (empty($foto)){ // se não existir nova imagem
    $foto = $foto_velha;
} else { // se existir nova imagem
    
    // if($foto_velha == "semfoto.jpg" ){ // caso não existia imagem
        $foto = microtime().".jpg"; // gera o nome timestamp com microssegundos

            if ($foto_velha != "semfoto.jpg" ) {
                unlink("img/" . $foto_velha);
                unlink("img/thumb_" . $foto_velha);
            }

    // } else { // se já existia imagem recupera o nome
        // $foto = $foto_velha;
    // }
			
}

try{
    // atualizando os dados no banco
    $query = $conn->prepare("UPDATE usuarios 
        SET nome=?, idade=?, foto=? WHERE id =?");
    $query->bindvalue(1,$nome);
    $query->bindvalue(2,$idade);
    $query->bindvalue(3,$foto);
    $query->bindvalue(4,$id);
    $query->execute();

    echo $foto;
}
catch(PDOException $e){
    echo "Falha ao inserir dados ". $e->getMessage();
}