<?php
  include "app/php/db.php";

  if(isset($_COOKIE['hash'])){
    header("location: errorLogin2.php");
  }

  if(isset($_POST['register'])){
    $users = $_POST['user'];
    $email = $_POST['email']; 
    $pass = md5($_POST['pass']);
    $cpass = md5($_POST['cpass']);

    if($pass == $cpass){
      $query = mysqli_query($conn, "SELECT * FROM accounts WHERE email = '$email'");
      $result = mysqli_num_rows($query);
      if($result < 1){
        $query2 = mysqli_query($conn, "SELECT * FROM accounts WHERE user = '$users'");
        $result2 = mysqli_num_rows($query2);
        if($result2 < 1){
        $hash = generateHash();
        mysqli_query($conn, "INSERT INTO `accounts`(`hash`, `user`, `email`, `pass`, `icon`, `wallet`, `compras`, `adm`) 
        VALUES ('$hash', '$users','$email','$pass','app/img/default.png','0','0','0')");
        mysqli_query($conn, "INSERT INTO `totalclient`(`user`, `resources`, `licencas`, `valor`) VALUES ('$users','0','0','0')");
        setcookie("hash", $hash);
        header("location: ../");
        }else{
          $error = "Usuário já cadastrado!";
        }
      }else{
        $error = "Email já cadastrado!";
      }
    }else{
      $error = "Senhas não confirmada!";
    }
  }else{
    $error = "";
  }
?>
<!DOCTYPE html>
<html lang="pt-br" >
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Leinad Code">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="app/css/login.css">
    <link rel='icon' href='app/img/favicon.png' type='image/png'>
    <title>TM STORE</title>
</head>
<body class="login">
    <div class="container">
      <div class="left">
        <div class="header">
          <img src="app/img/favicon.png">
          <h2>Criar uma conta</h2>
          <span style="color: red"><?php echo $error ?></span>
        </div>

        <form method="POST" class="form">
        <input type="text" name="user" placeholder="Nome">

          <input type="email" name="email" placeholder="Email">

          <input type="password" name="pass" placeholder="Senha">

          <input type="password" name="cpass" placeholder="Confirmar Senha">

          <span class="forgot" style="color: rgb(182, 182, 182); font-size: .75rem">Ao criar uma conta você concorda com todos os <a href="termos.php">termos e condições</a> da TM STORE.</span>

          <button type="submit" name="register">Continuar</button>

          <div class="singin">
            <p>Já tem uma conta? <span><a href="login.php">Fazer login</a></span></p>
          </div>
        </form>
      </div>
    </div>
</body>
</html>