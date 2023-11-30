<?php

require_once ('../vendor/autoload.php'); // if you use Composer
//require_once('ultramsg.class.php'); // if you download ultramsg.class.php
    
$token="qncba72opp2s0u8b"; // Ultramsg.com token
$instance_id="instance68032"; // Ultramsg.com instance id
$client = new UltraMsg\WhatsAppApi($token,$instance_id);
    
$to="+5511997607960"; 
$body="https://ricnaba.com.br/mobi/frontend/voucher.php?id=4"; 
$api=$client->sendChatMessage($to,$body);
print_r($api);