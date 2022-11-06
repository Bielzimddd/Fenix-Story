<?php
    include "app/php/import.php";
    if(isset($_POST['logar'])){
        $email = $_POST['email'];
        $pass = $_POST['pass'];

        $query = mysql_query("SELECT * FROM users WHERE email = '$email'");
        $arr = mysql_fetch_array($query);
        if(mysql_num_rows($query) > 0){
            if($pass == $arr['pass']){
                setcookie("hash", $arr['hash']);
                $success = "Logado com sucesso!";
                $error = "";
            }
        }else{
            $error = "Email não encontrado!";
            $success = "";
        }
    }else{
        $error = "";
        $success = "";
    }
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leinad Code</title>
</head>
<body>
    <h1>Faça seu login</h1>
    <span style="color: red"><?php echo $error ?></span>
    <span style="color: green"><?php echo $success ?></span>
    <form method="POST">
        <input type="email" name="email">
        <input type="password" name="pass">
        <button type="submit" name="logar">EMTRAR</button>
    </form>
</body>
</html>