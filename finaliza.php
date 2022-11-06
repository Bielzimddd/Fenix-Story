<?php
    include "app/php/db.php";
    $hash = $_COOKIE['hash'];
    if(!isset($_COOKIE['hash'])){
      header("location: errorLogin.php");
    }

    $id = $_GET['id'] OR header("location: ../404.php");
    $queryFaturaTT = mysqli_query($conn, "SELECT * FROM pagamentos WHERE idItem = '$id'");
    $resultFaturaTT = mysqli_num_rows($queryFaturaTT);
    if($resultFaturaTT > 0){

      /* Query User*/
      $queryUser = mysqli_query($conn, "SELECT * FROM accounts WHERE hash = '$hash'");
      $arrU = mysqli_fetch_assoc($queryUser);
      $user = $arrU['user'];

      /* Query faturas*/
      $queryFatura = mysqli_query($conn, "SELECT * FROM pagamentos WHERE user = '$user'");
      $arrF = mysqli_fetch_assoc($queryFatura);
      /* Query products */
      $queryProduct = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
      $arr = mysqli_fetch_assoc($queryProduct);
      
      /*Query Cupons*/
      $queryCupons = mysqli_query($conn, "SELECT * FROM cupons");
      $arrC = mysqli_fetch_assoc($queryCupons);

      $valor = $arrF['price'];
      $success = "";
      $error = "";

      if(isset($_POST['attcupom'])){
        $cupom = $_POST['cupom'];

        if($arrC['cupom'] == $cupom){
          if($arrF['cupom'] == 'false'){
            if($arrC['status'] == 'true'){
              $usos = $arrC['usos'] + 1;
              mysqli_query($conn, "UPDATE `cupons` SET `usos`='$usos'");
              $cupomativo = $arrC['valor'];
              $valor = $arrF['price']-( $arrF['price'] / 100 * $cupomativo);
              mysqli_query($conn, "UPDATE `pagamentos` SET `price`='$valor', `cupom`='true' WHERE user='$user'");
              $success = "Cupom ativo com sucesso!<br> -$cupomativo% de desconto!";
              $error = "";
            }else{
              $error = "Cupom suspenso!";
            }
          }else{
            $error = "Cupom já está ativo!";
          }
        }else{
          $error = "Cupom inválido!";
          $success = "";
        }
      }
    }else{
      header("location: ../404.php");
    }
?>
<!DOCTYPE html>
<html lang="pt-br" >
<head>
    <meta charset="UTF-8">
    <meta name="author" content="Leinad Code">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="app/css/style.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.js"></script>
    <link rel='icon' href='app/img/favicon.png' type='image/png'>
    <title>Leinad Code</title>
</head>
<body>
    
        <section class="apresentation">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container-md">
                  <img src="app/img/logo.png" class="navbar-brand">
                  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarScroll">
                    <ul class="navbar-nav me-auto my-2 my-lg-0" style="margin-left: 15px;" >
                      <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="index.php"> <i class="fas fa-home"></i> Início</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link active" href="../#products">
                            <i class="fas fa-box"></i> Mapas
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="termos.php"><i class="fas fa-clipboard-list"></i> Termos</a>
                      </li>
                    </ul>
                    <?php
                      if(isset($_COOKIE['hash'])){
                        echo '<a class="btn btn-log" href="panel" type="submit"><i class="far fa-user"></i> Área Do Cliente</a>';
                      }else{
                      echo '<a class="btn btn-log" href="login.php" type="submit"><i class="far fa-user"></i> Área Do Cliente</a>';
                      }
                      if(isset($_COOKIE['hash'])){
                      $hash = $_COOKIE['hash'];
                      $query = mysqli_query($conn, "SELECT * FROM accounts WHERE hash = '$hash'");
                      $resultadoconta = mysqli_num_rows($query);
                      if($resultadoconta > 0){
                      $arr = mysqli_fetch_assoc($query);
                      if($arr['adm'] > 0){
                        echo '<a class="btn btn-log" href="panel/admin" type="submit" style="margin-left: 5px"><i class="far fa-user"></i> Área Administrador</a>';
                      }
                    }else{
                      header("location: errorCookie.php");
                    }
                    }
                      ?>
                </div>
              </nav>
        </section>

        <section class="scriptcontent">
          <div class="container">
            <div class="row">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb text-center">
                <li class="breadcrumb-item" style="margin-left: 20px;">Início</li>
                <li class="breadcrumb-item">Checkout</li>
                <li class="breadcrumb-item active" aria-current="page">teste</li>
              </ol>
            </nav>

              <div class="col-md-7">
                <div class="demo1" style="height: 330px;">
                  <p class="name">Pedido</p>
                  <div class="checkout">
                  <i class="fas fa-box-open"></i>
                    <p class="name"><?php echo $arr['title'] ?></p>
                    <p class="price"><span>R$ </span><?php echo $arr['price'] ?>,00</p>
                  </div>
                </div>
              </div>
              <div class="col-md-5" style="overflow:hidden; height:420px;">
                <div class="demo2 text-center" style="height: 380px;">
                  <p class="name">Checkout</p>
                  <span style="color: green"><?php echo $success ?></span>
                  <span style="color: red"><?php echo $error ?></span>
                  <form action="" method="POST">
                  <input type="text" name="cupom" placeholder="Cupom de Desconto" style="text-transform: uppercase">
                  <button class='sbuto' name="attcupom" type="submit">Validar Cupom</button>
                  </form>
                  <br>
                  <p class="price"><span>Valor final:</span> <?php echo $valor = number_format($valor,2,",",","); ?></p>
                  <a class="btn btn-success" id="btnMP" href="fatura.php?id=<?php echo $arr['id'] ?>">Pagar</a>      </div>
                </div>
            </div>
            </div>
          </div>
        </section>

  <section class="footer">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img src="app/img/logo.png">
          <p class="copy">Todos os direitos reservados ©️</p>
        </div>
        <div class="col-md-6 text-end my-4">
          <a class="social" href="https://discord.gg/w4Y9RDY8A2"><i class="fab fa-discord"></i></a>
          <a class="social" href="https://www.youtube.com/channel/UC-sx_mjFgI-TENM-3F0XoVQ"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
    </div>
  </section>
  <script>
    document.onkeydown = function(e) {
  if(event.keyCode == 123) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
     return false;
  }
}
  </script>
  <script>
    function myFunction() {
      alert("Site protegido!");
      return false
    }
    </script>
  <script>
    $(".number").counterUp({
      time: 1000
    });
  </script>
</body>
</html>