<?php

include_once 'topo.html';
include_once '../backend/config.php';
$id = $_GET['id'] ?? '';

$url = $urlUser . "?id=" . $id . "&img=s";

// chamando a função e recebendo dados atualizados
$res = json_decode(file_get_contents($url));

// verificando se existem dados
if ($res == null) {
    echo "<h3 class='text-danger'>Usuário não encontrado!</h3>";
    echo "<a href=read.php class='btn btn-outline-info'>Voltar</a>";
    exit();
} else {
    // recebendo os dados 
    foreach ($res as $r) {
        $nome = $r->nome;
        $idade = $r->idade;
        $foto = $r->foto;
    }
}
?>

<div class="row mt-5 justify-content-center">
    <div class="col-6">
        <!-- montando o firmulário com os dados do banco -->
        <form class="was-validated" action="<?= $urlUser ?>" method="post" enctype='multipart/form-data'>
            <!-- dados para uso posterior -->
            <input type="hidden" name="metodo" value="put">
            <input type="hidden" name="id" value="<?= $r->id ?>">
            <input type="hidden" name="site" value="1">

            <h3 class="titulo mb-3">Alterar Usuário <small class="text-danger">*Campos Obrigatorios</small></h3>

            <div class="row">
                <div class="col">
                    <label>Nome:<small class="text-danger">*</small></label>
                    <input class="form-control" placeholder="Informe o nome" type="text" name="nome" maxlength="100" value="<?= $nome ?>" required />
                    <div class="invalid-feedback">O campo nome é obrigatório.</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Idade:<small class="text-danger">*</small></label>
                    <input class="form-control" placeholder="Informe a idade" type="text" name="idade" maxlength="3" value="<?= $idade ?>" required />
                    <div class="invalid-feedback">O campo idade é obrigatório.</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Foto:</label>
                    <input class="form-control" type="file" name="foto" />
                    <!-- exibindo miniatura da imagem atual  -->
                    <img src="<?= $urlImg . $foto ?>" width="50" />
                    <!-- guardando o nome do arquivo da imagem  -->
                    <input type="hidden" name="foto_old" value="<?= $foto ?>" />
                </div>
            </div>
            <div class="row">
                <div class="col text-right">
                    <button type="submit" class="btn btn-primary mt-4">ATUALIZAR</button>
                </div>
            </div>
        </form>
        <!-- botão para cancelar -->
        <div class="text-right mt-2">
            <a href='details.php?id=<?= $r->id ?>' class='btn btn-outline-info'>Cancelar</a>
        </div>
    </div>
</div>

<?php
include_once 'rodape.html';
?>