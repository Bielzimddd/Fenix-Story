<?php
    include "app/php/db.php";
    if(!isset($_COOKIE['hash'])){
        header("location: errorLogin.php");
    }else{
    $hash = $_COOKIE['hash'];
    $account = mysqli_query($conn, "SELECT * FROM accounts WHERE hash = '$hash'");
    $arrU = mysqli_fetch_assoc($account);
    $resultAccount = mysqli_num_rows($account);
    if($resultAccount > 0){
        $id = $_GET['id'] OR header("location: ../");
        $produto = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
        $resultProduto = mysqli_num_rows($produto);
        if($resultProduto > 0){
            $arrP = mysqli_fetch_assoc($produto);
            $title = $arrP['title'];
            $ref = rand(5000, 50000);
            $user = $arrU['user'];
            $price = $arrP['price'];
            $date = date("Y-m-d H:m:s");
            $idItem = $arrP['id'];
            mysqli_query($conn, "INSERT INTO `pagamentos`(`title`, `ref`, `user`, `status`, `price`, `date`, `idItem`, `cupom`) 
            VALUES ('$title','MP-$ref','$user','Pendente','$price','$date','$idItem', 'false')");
            header("location: finaliza.php?id=$idItem");
        }else{
            header("location: 404.php");
        }
    }else{
        header("location: errorCookie.php");
    }
}
?>