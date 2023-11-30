<?php
include_once 'topo.html';
include_once '../backend/config.php';


$id = $_GET['id'] ?? '';


    $url = $urlImg."?id=".$id;
	$res = json_decode(file_get_contents($url));


if ($res == null){
    echo "<h3 class='text-danger'>Usuário não encontrado!</h3>";
    echo "<a href=read.php class='btn btn-outline-info'>Voltar</a>";
    exit();
} else {
    foreach($res as $r){
    $nome = $r->nome;
    $idade = $r->idade;
    $foto = $r->foto;
    }
}
?>

<div class="row mt-5 justify-content-center">
    <div class="col-6">

        <form class="was-validated" action="<?= $urlUp ?>" method="post" enctype='multipart/form-data'>
            
            <input type="hidden" name="metodo" value="img">
            <input type="hidden" name="id" value="<?= $r->id ?>">

            <div class="row">
                <div class="col">
                    <label>Foto:</label>
                    <input class="form-control" type="file" name="foto" />
                    <img src="<?= $foto ?>" width="50"/>
                </div>
            </div>


            <div class="row">
                <div class="col text-right">
                    <button type="submit" class="btn btn-primary mt-4">TROCAR</button>
                </div>
            </div>

        </form>
        <div class="text-right mt-2">
        <a href='details.php?id=<?= $r->id ?>' class='btn btn-outline-info'>Cancelar</a>
        </div>
    </div>
</div>

<?php
include_once 'rodape.html';
?>