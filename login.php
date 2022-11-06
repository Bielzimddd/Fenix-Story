<?php
  include "app/php/db.php";

  if(isset($_COOKIE['hash'])){
    header("location: errorLogin2.php");
  }

  if(isset($_POST['login'])){
    $users = $_POST['user'];
    $pass = md5($_POST['pass']);
    $query = mysqli_query($conn, "SELECT * FROM accounts WHERE user = '$users'");
    $result = mysqli_num_rows($query);
    if($result > 0){
      $arr = mysqli_fetch_assoc($query);
      if($pass == $arr['pass']){
        $_SESSION['User'] = $users;
        header("location: ../");
      }else{
        $error = "Senha incorreta!";
      }
    }else{
      $error = "Usuário não encontrado!";
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
          <h2>Boas vindas de volta!</h2>
          <span style="color: red"><?php echo $error ?></span>
        </div>

        <form method="POST" class="form">
          <input type="text" name="user" placeholder="Usuário">

          <input type="password" name="pass" placeholder="Senha">

          <span class="forgot"><a href="#">Esqueceu a senha?</a></span>

          <button type="submit" name="login">Entrar</button>

          <div class="singin">
            <p>Precisando de uma conta? <span><a href="registro.php">Registre-se</a></span></p>
          </div>
        </form>
      </div>
    </div>
</body>
</html>