<?php

$nome = $_POST['nome'];
$idade = $_POST['idade'];
$foto = $_POST['foto'];

try{
    include_once("conexao.php");
    // salvando os dados no banco
    $query = $conn->prepare("INSERT INTO usuarios SET nome=?, idade=?, foto=?");
    $query->bindvalue(1,$nome);
    $query->bindvalue(2,$idade);
    $query->bindvalue(3,$foto);
    $query->execute();
}
catch(PDOException $e){
    echo "Falha ao inserir dados ". $e->getMessage();
}