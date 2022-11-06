<?php
    include "app/php/db.php";
    $id = $_GET['id'] OR header("location: ../");

    $query = mysqli_query($conn, "SELECT * FROM products WHERE id = '$id'");
    $result = mysqli_num_rows($query);
    if($result > 0){
        $arr = mysqli_fetch_assoc($query);
    }else{
        header("location: ../");
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
    <title>TM STORE</title>
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
                        <a class="nav-link active" href="#">
                            <i class="fas fa-code"></i> Scripts
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
                <li class="breadcrumb-item">Scripts</li>
                <li class="breadcrumb-item active" aria-current="page">teste</li>
              </ol>
            </nav>

              <div class="col-md-6">
                <div class="demo1">
                  <p class="name"><?php echo $arr['title'] ?></p>
                  <p class="version">Versão Atual: <?php echo $arr['version'] ?>.0</p><p class="vendas">Compras: <?php echo $arr['compras'] ?></p>
                  <iframe width="560" height="315" src="https://www.youtube.com/embed/<?php echo $arr['youtube'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                  <p class="desc"><?php echo $arr['description'] ?></p>
                  <?php
                  $valor = $arr['price'];
                  $valorFormatado = number_format($valor,2,",",",");
                  echo '<p class="price"><span>R$</span>'.$valorFormatado.'</p>';
                  ?>
                </div>
              </div>
              <div class="col-md-6">
                <div class="demo2">
                  <p class="name">Últimos Updates</p>
                  <div class="dash-content">
                  </div>
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