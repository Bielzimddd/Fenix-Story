<?php
    include "app/php/db.php";
    $extRef = $_GET['external_reference'] OR header("location: ../");
    $query = mysqli_query($conn, "SELECT * FROM pagamentos WHERE ref = '$extRef'");
    $arr = mysqli_fetch_assoc($query);
    $id = $arr['idItem'];
    mysqli_query($conn, "DELETE FROM pagamentos WHERE hash = '$extRef'");

    $hash = $_COOKIE['hash'];
    $queryUser = mysqli_query($conn, "SELECT * FROM accounts WHERE hash = '$hash'");
    $arrU = mysqli_fetch_assoc($queryUser);

    $name = $arrU['user'];

    /* Webhook */

    $webhookurl = "https://discord.com/api/webhooks/975927517405921340/vWQorvrvpZsI4UG6qOne-rPtNnkGDZl7Wd1n9EZ4RQVvb2848oSDiz0T-8bU6gG8UUQb";

//=======================================================================================================
// Compose message. You can use Markdown
// Message Formatting -- https://discordapp.com/developers/docs/reference#message-formatting
//========================================================================================================

$timestamp = date("c", strtotime("now"));

$json_data = json_encode([
    // Text-to-speech
    "tts" => false,

    // File upload
    // "file" => "",

    // Embeds Array
    "embeds" => [
        [
            // Embed Title
            "title" => "**TM STORE**",

            // Embed Type
            "type" => "rich",
            // Embed Description
            "description" => "A Fatura do usuário: $name foi cancelada!",

            // URL of title link
            "url" => "https://localhost",

            // Timestamp of embed must be formatted as ISO8601
            "timestamp" => $timestamp,

            // Embed left border color in HEX
            "color" => hexdec( "#ff0000" ),

            // Footer
            "footer" => [
                "text" => "Coypright © TM STORE",
            ],
        ]
    ]

], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );


$ch = curl_init( $webhookurl );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec( $ch );
// If you need to debug, or find out why you can't send message uncomment line below, and execute script.
// echo $response;
curl_close( $ch );
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app/css/fatura.css">
    <title>Leinad Code</title>
</head>
<body>
    <div class="container">
        <div class="left">
            <div class="form">
                <h1 style="color: red">Falha no pagamento</h1>
                <p>Houve uma falha em seu pagamento, mas se você quiser você pode tentar novamente!</p>
                <a href="index.php" class="btn">Inicio</a>
                <a href="index.php#products" class="btn">Tentar novamente</a>
            </div>
        </div>
    </div>
</body>
</html>