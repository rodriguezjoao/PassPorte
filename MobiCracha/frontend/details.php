<?php

include_once 'topo.html';
include_once '../backend/config.php';


$id = $_GET['id'];
$url = "$urlUser" . "?id=" . $id;

// chamando a função e recebendo os detalhes do usuário
$resultado = json_decode(file_get_contents($url));

echo "<div class='col-5 mt-5'>";
if ($resultado == null) {
	echo "<h3 class='text-danger'>Não foram encontrados dados!</h3>";
} else {
	foreach ($resultado as $r) {
?>
		<div class="card mt-3">
			<div class="card-header">
				<h1><?= $r->nome ?></h1>
			</div>
			<div class="card-body">
				<img class="float-start" src="<?= $urlImg . $r->foto ?>" style="width: 200px; margin-right: 10px" alt='"<?= $r->nome ?>"'>
				<div>
					<p class='card-text'>
						Nome: <b><?= $r->nome ?></b><br>
						Idade: <b><?= $r->idade ?></b><br>
					</p>
					<!-- botão para atualização -->
					<p class="text-right">
						<a href="update.php?id=<?= $r->id ?>" class="btn btn-outline-warning btn-sm">Atualizar</a>
					</p>
					<!-- botão para exclusão -->
					<p class="text-right">
						<a href="<?= $urlUser . '?site=1&metodo=del&id=' . $r->id ?>" class="btn btn-outline-danger btn-sm mt-2" onclick="return confirm('Tem certeza que deseja excluir o usuário: <?= $r->nome ?>');">Excluir</a>
					</p>
					<!-- botão para voucher -->
					<p class="text-right" style="margin-top:30px;">
						<a href="voucher.php?id=<?=$r->id;?>&idade=<?=$r->idade;?>&at=1" class="btn btn-outline-success btn-sm">Voucher</a>
					</p>
				</div>
			</div>
		</div>


<?php
	}
}
echo "</div>";
echo '<a href="read.php" class="btn btn-sm btn-secondary mt-5">Voltar</a>';

include_once 'rodape.html';

