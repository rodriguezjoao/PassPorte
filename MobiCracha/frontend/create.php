<?php

include_once 'topo.html';
include_once '../backend/config.php';

?>
<!-- formulário para cadastro de usuário -->
<div class="row mt-5 justify-content-center">
    <div class="col-6">
        <form class="was-validated" action="<?= $urlUser ?>" method="post" enctype='multipart/form-data'>
            <h3 class="titulo">Incluir Usuário <small class="text-danger">*Campos Obrigatorios</small></h3>

            <input type="hidden" name="site" value="1">

            <div class="row">
                <div class="col">
                    <label>Nome:<small class="text-danger">*</small></label>
                    <input class="form-control" placeholder="Informe o nome" type="text" name="nome" maxlength="100" required />
                    <div class="invalid-feedback">O campo nome é obrigatório.</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Idade:<small class="text-danger">*</small></label>
                    <input class="form-control" placeholder="Informe a idade" type="text" name="idade" maxlength="15" required />
                    <div class="invalid-feedback">O campo idade é obrigatório.</div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <label>Foto:</label>
                    <input class="form-control" type="file" name="foto" />
                </div>
            </div>
            <div class="row">
                <div class="col text-right">
                    <button type="submit" class="btn btn-primary mt-4">CADASTRAR</button>
                </div>
            </div>
        </form>
    </div>
</div>

</div>

<?php
include_once 'rodape.html';
?>