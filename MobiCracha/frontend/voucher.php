<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Api Json</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        img[src*="https://cdn.000webhost.com/000webhost/logo/footer-powered-by-000webhost-white2.png"] {
            display: none;
        }

        .voucher {
            display: none;
        }
    </style>
</head>
<!-- menu superior das páginas -->

<body>

    <?php

    // include_once 'topo.html';
    include_once '../backend/config.php';

    $id = $_GET['id'];
    $url = "$urlUser" . "?id=" . $id;
    
    // Usar o use para carregar classe através do Composer
    use chillerlan\QRCode\{QRCode, QROptions};

    // Incluir Composer
    include_once('../vendor/autoload.php');


    // Criar a variável com a URL para o QRCode
    // $data = "https://ricnaba.com.br/mobi/frontend/voucher.php?id=".$id."&at=0";
    $data = $urlFront."voucher.php?id=".$id."&at=0";

    // Instanciar a classe para enviar os parâmetros para o QRCode
    $options = new QROptions([
        // Número da versão do código QRCode
        'version' => 7,
        // escala da imagem 
        'scale' => 4,
        // Alterar para base64
        'imageBase64' => true,
    ]);

    // Gerar QRCode: instanciar a classe QRCode e enviar os dados para o render gerar o QRCode
    $qrcode = (new QRCode($options))->render($data);
    // var_dump($qrcode);
    // die();

    
    

    // chamando a função e recebendo os detalhes do usuário
    $resultado = json_decode(file_get_contents($url));

    // echo "<div class='col-12 mt-5'>";
    if ($resultado == null) {
        echo "<h3 class='text-danger'>Não foram encontrados dados!</h3>";
    } else {
        foreach ($resultado as $r) {
            ?>
            <div id="cracha" class="card" style="position: absolute;
                    top: 20px;
                    left: 20px;">
                <div class="card-header">
                    <h1>
                        <?= $r->nome ?>
                    </h1>
                </div>
                <div class="card-body">
                    <img class="float-start" src="<?= $urlImg . $r->foto ?>" style="width: 150px; margin-right: 10px"
                        alt='"<?= $r->nome ?>"'>
                        <div style="clear:both"></div>
                    <div>
                        <p class='card-text'>
                            Nome: <b>
                                <?= $r->nome ?>
                            </b><br>
                            Idade: <b>
                                <?= $r->idade ?>
                            </b><br>
                        </p>

                        
                        <div style="text-align: center;"><img src="<?= $qrcode; ?>"></div>
                        

                    </div>
                </div>
            </div>

            <?php
        }
    }
    echo "</div>";
    include_once 'rodape.html';
    
    // verifica se já foi enviado o voucher
    $ativo = $_GET['at'];

    if($ativo == 1){
        echo '<div style="margin-top:580px"></div>';
        echo '<a href="read.php" class="btn btn-sm btn-secondary mt-5" style="margin-top: 100px;">Voltar</a>';
    // envio do voucher pelo whatsapp
    
    require_once ('../vendor/autoload.php'); // if you use Composer
    //require_once('ultramsg.class.php'); // if you download ultramsg.class.php
        
    $token="qncba72opp2s0u8b"; // Ultramsg.com token
    $instance_id="instance68032"; // Ultramsg.com instance id
    $client = new UltraMsg\WhatsAppApi($token,$instance_id);
        
    // $to="+5511973545791"; 
    // $to="+5511997607960"; 
    $to="+55".$r->idade; 
    // $body="https://ricnaba.com.br/mobi/frontend/voucher.php?id=$r->id&at=0"; 
    $body=$urlFront."voucher.php?id=$r->id&at=0"; 
    $api=$client->sendChatMessage($to,$body);
    // print_r($api);
  
    }
 

    ?>