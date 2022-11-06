<?php
    include "mp.php";
    include "app/php/db.php";
    $extRef = $_GET['external_reference'] OR header("location: ../");
    $query = mysqli_query($conn, "SELECT * FROM pagamentos WHERE ref = '$extRef'");
    $arr = mysqli_fetch_assoc($query);
    $id = $arr['idItem'];
    $user = $arr['userHash'];
    $result = mysqli_num_rows($query);
    if($result < 0){
        header("location: ../");
    }
    $filters = array(
        "external_reference" => "$extRef"
    );

    $payment = MercadoPago\Payment::search($filters);
    $status = $arr['status'];
    if($payment[0]->status == "approved"){
        if($status == "Pendente"){
            mysqli_query($conn, "INSERT INTO `compras`(`userHash`, `itemId`) 
            VALUES ('$user','$id')");
            $valorquetem = mysqli_query($conn, "SELECT * FROM total");
            $arrT = mysqli_fetch_assoc($valorquetem);
            $valortotal = $arrT['valortotal'] + $arr['price'];
            mysqli_query($conn, "UPDATE total SET `valortotal`='$valortotal'");

            $queryClient = mysqli_query("SELECT * FROM accounts WHERE hash = '$hash'");
            $arrCl = mysqli_fetch_assoc($queryClient);
            $user = $arrCl['user'];

            $queryTotalClient = mysqli_query("SELECT * FROM totalclient WHERE user = '$user'");
            $arrTC = mysqli_fetch_assoc($queryTotalClient);
            $valor2 = $arrTC['valor'] + 1;
            $resources = $arrTC['resources'] + 1;
            mysqli_query($conn, "UPDATE totalclient SET `resources`='$resources', `valor`='$valor2' WHERE user = '$user'");
            
            mysqli_query($conn, "UPDATE pagamentos SET status='Aprovado' WHERE ref = '$extRef'");
        }else{
            header("location: ../");
        }
    }else{
        header("location: ../");
    }

    $hash = $_COOKIE['hash'];
    $queryUser = mysql_query("SELECT * FROM users WHERE hash = '$hash'");
    $arrU = mysql_fetch_array($queryUser);

    $name = $arrU['name'];
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
            "description" => "A Fatura do usuário: $name foi aprovada com sucesso!",

            // URL of title link
            "url" => "https://localhost",

            // Timestamp of embed must be formatted as ISO8601
            "timestamp" => $timestamp,

            // Embed left border color in HEX
            "color" => hexdec( "#00ff00" ),

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
    <title>TM STORE</title>
</head>
<body>
    <div class="container">
        <div class="left">
            <div class="form">
                <h1 style="color: green">Pagamento aprovado</h1>
                <p>Seu pagamento foi aprovado e ja foi adicionado a sua conta. Clique nas opções abaixo para saber mais!</p>
                <a href="index.php" class="btn">Inicio</a>
                <a href="panel/scripts.php" class="btn">Compras</a>
            </div>
        </div>
    </div>
</body>
</html>