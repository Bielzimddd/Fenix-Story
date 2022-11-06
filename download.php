<?php
    include "app/php/db.php";
    if(!isset($_COOKIE['hash'])){
        header("location: errorLogin.php");
    }
    $id = $_GET['id'] OR header("location: ../");

    $query = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
    $result = mysqli_num_rows($query);
    if($result > 0){
        if(isset($_COOKIE['hash'])){
            $arr = mysqli_fetch_assoc($query);
            if($arr['price'] < 1){
                $download = $arr['download'];
                header("location: $download");
            }else{
                $hash = $_COOKIE['hash'];
                $queryP = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
                $queryC = mysqli_query($conn, "SELECT * FROM compras WHERE userHash = '$hash'");
                $productsCount = mysqli_num_rows($queryP);
                $purchasesCount = mysqli_num_rows($queryC);
                $myProducts = array();

                for($i = 0; $i < $productsCount; $i++)
                {
                $arrP = mysqli_fetch_assoc($queryP);          

                for($i2 = 0; $i2 < $purchasesCount; $i2++)
                {
                    $arrP2 = mysqli_fetch_assoc($queryC);
                    
                    $ceira1 = $arrP['id'];
                    $ceira = $arrP2['itemId'];
                    $log = "product_id: $ceira1, purchaseID: $ceira";
                    echo "<script>console.log('$log')</script>";
                    
                    if($arrP['id'] == $arrP2['itemId'])
                    { 
                    $myProducts[$i] = $arrP;
                    }
                }
                
                if ($purchasesCount >= 1)
                {
                    mysqli_data_seek($queryC, 0);
                }

                }

                foreach($myProducts as $key => $value){
                    $download = $value['download'];
                    header("location: $download");
                    }
                }
            }else{
                header("location: login.php");
        }
    }else{
        header("location: ../");
    }
?>