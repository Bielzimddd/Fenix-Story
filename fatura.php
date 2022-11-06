<?php
    include "app/php/db.php";
    include "mp.php";
    if(isset($_COOKIE['hash'])){
        $hash = $_COOKIE['hash'];
        $qUser = mysqli_query($conn, "SELECT * FROM accounts WHERE hash = '$hash'");
        $uArr = mysqli_fetch_array($qUser);
    }else{
        header("location: ../");
    }

    $id = $_GET['id'] OR header("location: ../");
    $queryFatura = mysqli_query($conn, "SELECT * FROM pagamentos WHERE idItem = '$id'");
    $arrF = mysqli_fetch_assoc($queryFatura);

    $query = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
    $result = mysqli_num_rows($query);
    if($result > 0){
        $arr = mysqli_fetch_assoc($query);
    }else{
        header("location: ../");
    }

    # Create a preference object
    $preference = new MercadoPago\Preference();
    # Create an item object
    $item = new MercadoPago\Item();
    $item->id = "$id";
    $item->title = $arr['title'];
    $item->quantity = 1;
    $item->currency_id = "BRL";
    $item->unit_price = $arrF['price'];
    # Create a payer object
    $payer = new MercadoPago\Payer();
    $payer->email = $uArr['email'];
    $payer->name = $uArr['name'];
    # Settings preference properties
    $preference->items = array($item);
    $preference->payer = $payer;
    # Redirect
    $url = "https://localhost";
    $preference->back_urls = array(
        "success" => "$url/paymentSuccess.php",
        "failure" => "$url/paymentFailure.php",
        "peding" => "$url/paymentPeding.php"
    );
    $preference->auto_return = "approved";
    # Hash
    $extRef = $arrF['ref'];
    $preference->external_reference = "$extRef";
    # Save and posting preference
    $preference->save();
    $price = $arr['price'];
    $date = date("Y-m-d H:i:s");
    $title = $arr['title'];

    header("location: $preference->init_point");
?>