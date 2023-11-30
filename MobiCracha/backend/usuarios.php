<?php
// recebendo o método da solicitação
$request_method = $_SERVER["REQUEST_METHOD"];

// verificando qual solicitação
switch ($request_method) {
		// listar ou excluir
	case 'GET':
		// deletar
		if ((isset($_GET['metodo'])) && ($_GET['metodo']) == "del") {
			$id = intval($_GET["id"]);
			del_usuario($id); // chamando a função de exclusão
			break;
		} else {
			// listando um
			if (!empty($_GET["id"])) {
				$id = intval($_GET["id"]);
				get_usuarios($id); // chamando a função para listar os dados do usuário específico
			}
			// listando todos
			else {
				get_usuarios(); // chamando a função listar todos
			}
		}
		break;
		// incluir ou alterar
	case 'POST':
		// verificando se é alteração
		if ((isset($_POST['metodo'])) && ($_POST['metodo']) === "put") {

			if ((isset($_POST['site'])) && ($_POST['site']) == "1") {
				put_usuarios($_POST); // chamando a função de alteração para desktop
				break;
			} else {
				put_usuarios_cel($_POST); // chamando a função de alteração para celular
				break;
			}
			// se for inclusão via web/celular
		} elseif ((isset($_POST['site'])) && ($_POST['site']) == 1) {
			post_usuarios($_POST); // chamando a função de inclusão via web
			break;
		} else {
			post_user_cel($_POST); // chamando a função de inclusão via celular
			break;
		}
	default:
		// Método ínválido
		header("HTTP/1.0 405 - Método não permitido");
		break;
}

// função para listagem
function get_usuarios($id = 0) // assume valor zero ser for todos
{
	include("conexao.php");
	$query = "SELECT * FROM usuarios ORDER BY nome"; // busca todos e ordena por nome
	if ($id != 0) { // verifica se é para listar único
		$query = "SELECT * FROM usuarios WHERE id=" . $id . " LIMIT 1";
	}

	// cria a instrução
	$result = $conn->query($query);
	$result->execute();
	$response = array();

	// cria o array com os dados do banco
	$res = $result->fetchAll(PDO::FETCH_OBJ);
	foreach ($res as $r) {
		$response[] = $r;
	}
	// configura cabeçalho para json
	header('Content-Type: application/json');
	// cria o json com a consulta
	echo json_encode($response);
}

// função para inclusão via web
function post_usuarios($dados)
{
	include_once 'config.php';
	$site = $_POST["site"] ?? "0";

	// confima que é via web
	if ($site) {
		// verifica se existe imagem
		if (!empty($_FILES["foto"]["name"])) {
			$img = true;
			$url = $urlFoto;
			$foto = microtime() . ".jpg"; // gera o nome timestamp com microssegundos 
		} else {
			$img = false;
		}

		// existindo imagem prepara os dados para upload
		if ($img) {
			$ch = curl_init();
			$cFile = new CURLFile($_FILES['foto']['tmp_name'], $_FILES['foto']['type'], $_FILES['foto']['name']);

			$data = array('imagem' => $cFile, 'foto' => $foto);

			// chamando a bibloteca curl para upload
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_exec($ch);
			curl_close($ch);
			// guardando o nome da imagem caregada
			$dados['foto'] = $foto;
		} else {
			// guarda o nome "semfoto"
			$dados['foto'] = "semfoto.jpg";
		}
	}

	// prepara os dados para salvar no banco de dados
	$iniciar = curl_init($urlIns);

	curl_setopt($iniciar, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($iniciar, CURLOPT_POST, true);
	curl_setopt($iniciar, CURLOPT_POSTFIELDS, $dados);
	curl_exec($iniciar);
	curl_close($iniciar);

	// retorna para a página de listagem atualizada
	header("Location:" . $urlFront . "read.php");
}

// função para inclusão via celular
function post_user_cel($dados)
{
	include_once 'config.php';

	// fazendo o upload da imagem caso ainda não tenha sido feito
	if (!isset($_POST['cel'])) {
		// recebe o nome da foto antiga
		$fotoOld = $_GET["foto"] ?? "";

		// apaga os arquivos anteriores em cao de atualização
		if ($fotoOld != "") {
			unlink("img/" . $fotoOld);
			unlink("img/thumb_" . $fotoOld);
		}
		
		$foto = microtime() . ".jpg"; // gera o nome timestamp com microssegundos

		$target_dir = 'img/'; // local se salvamento das imagens
		$data1 = file_get_contents('php://input');
		file_put_contents($target_dir . $foto, $data1); // faz o upload
		echo $foto; // retorna o nome da imagem carregada

		// gerando a miniatura
		if ($foto != "") {
			if (file_exists('img/' . $foto)) {
				$diretorio = "img/";
				$caminho = $diretorio . $foto;
				$caminho_thumb = 'img/thumb_' . $foto; // acrescenta thumb_ no noma da foto

				// criando uma lista com as informações da imagem
				list($width, $height, $type) = getimagesize($caminho);
				$tipo_imagem = image_type_to_mime_type($type);
				// especificando o tamanho da miniatura
				$new_width = 100;
				$new_height = 100;
				// criando a nova imagem
				$image_p = imagecreatetruecolor($new_width, $new_height);
				// só para tipos jpg (para outros ver documentação php)
				if ($tipo_imagem == 'image/jpeg') {
					$image = imagecreatefromjpeg($caminho);
					// é possível cortar a imagem, não é o nosso caso
					imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
					imagejpeg($image_p, $caminho_thumb, -1); // -1 é a qualidade original na imagem
				}
				imagedestroy($image_p); // apaga a imagem temporária criada
			}
		}
	} else { // se já fez upload




		// prepara os dados para salvar no banco de dados com curl
		$iniciar = curl_init($urlIns);
		curl_setopt($iniciar, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($iniciar, CURLOPT_POST, true);
		curl_setopt($iniciar, CURLOPT_POSTFIELDS, $dados);
		curl_exec($iniciar);
		curl_close($iniciar);

		echo "Dados salvos";
	}
}

// função para alteração via web
function put_usuarios($dados)
{
	include_once 'config.php';
	$site = $_POST["site"] ?? "0";

	$dados['foto'] = $_FILES['foto']['name'];
	// prepara os dados para alterar o banco de dados com curl
	$iniciar = curl_init($urlUp);
	curl_setopt($iniciar, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($iniciar, CURLOPT_POST, true);
	curl_setopt($iniciar, CURLOPT_POSTFIELDS, $dados);
	$foto = curl_exec($iniciar);
	curl_close($iniciar);


	// se houve troca de imagem 
	if (!empty($dados['foto'])) {
		// prepara os dados para fazer upload da imagem com curl
		$ch = curl_init();
		$cFile = new CURLFile($_FILES['foto']['tmp_name'], $_FILES['foto']['type'], $_FILES['foto']['name']);

		$data = array('imagem' => $cFile, 'foto' => $foto);

		// configurando/executando o curl
		curl_setopt($ch, CURLOPT_URL, $urlFoto);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_exec($ch);
		curl_close($ch);
	}

	if ($site) {
		// retornado para listagem atualizada
		header("location:$urlFront" . "read.php");
	} else {
		echo $id;
	}
}

// função para alteração via cel
function put_usuarios_cel($dados)
{
	include_once 'config.php';



	$iniciar = curl_init($urlUpCel);
	curl_setopt($iniciar, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($iniciar, CURLOPT_POST, true);
	curl_setopt($iniciar, CURLOPT_POSTFIELDS, $dados);
	curl_exec($iniciar);
	curl_close($iniciar);
}

// função para exclusão via web
function del_usuario($id)
{
	include("conexao.php");
	include_once 'config.php';
	$site = $_GET["site"] ?? "0";

	// recuperando o nome do arquivo
	$stm = "SELECT * FROM usuarios WHERE id=$id LIMIT 1";
	$result = $conn->query($stm);
	$result->execute();
	// excluindo o arquivo da pasta "img"
	$res = $result->fetch(PDO::FETCH_ASSOC);
	unlink("img/" . $res['foto']);

	// preparando/executando a instrução para exclusão no banco
	$query = "DELETE FROM usuarios WHERE id=" . $id;
	$conn->exec($query);

	// retornado para listagem atualizada
	if ($site) {
		header("location:$urlFront" . "read.php");
	} else {
		echo "OK";
	}
}
