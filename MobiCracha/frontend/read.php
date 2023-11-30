<?php

include_once 'topo.html';
include_once '../backend/config.php';

// chamando a função e recebendo lista de usuários
$resultado = json_decode(file_get_contents($urlUser));

echo "<div class='mt-5' style='display: flex; flex-wrap: wrap;'>";

// verificando se existem dados no banco
if ($resultado == null) {
	echo "<h3 class='text-danger'>Não foram encontrados dados!</h3>";
} else {
	// montando os cards com os dados dos usuários
	foreach ($resultado as $result => $r) {
?>
		<div class="card" style="width: 10rem; margin:10px;">
			<img class="card-img-top" src="<?= $urlImg . $r->foto ?>" alt="<?= $r->nome ?>">
			<div class="card-body">
				<p class="card-text">
					Nome: <?= $r->nome ?><br>
					Idade: <?= $r->idade ?><br>
				</p>
				<!-- botão para detalhamento -->
				<a href="details.php?id=<?= $r->id ?>" class="btn btn-outline-primary btn-sm">Saiba mais...</a>
			</div>
		</div>
<?php
	}
}
echo "</div>";
echo "<a href='index.php' class='btn btn-sm btn-secondary mt-5'>Voltar</a>";
include_once 'rodape.html';
?>