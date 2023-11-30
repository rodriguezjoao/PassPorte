<?php

include_once("conexao.php");

$id = $_POST['id'];
$nome = $_POST['nome'];
$idade = $_POST['idade'];
$foto = $_POST['foto'];
// $foto = $_POST['foto']??""; // nome da imagem

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