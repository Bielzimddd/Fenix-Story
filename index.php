<?php
  require('app/php/db.php');
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
                        <a class="nav-link active" aria-current="page" href="index.php"> <i class="fas fa-home"></i> Início</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="#products">
                            <i class="fas fa-box"></i> Produtos
                        </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" href="termos.php"><i class="fas fa-clipboard-list"></i> Termos</a>
                      </li>
                    </ul>
                    <form action="" class="d-flex">
                        <input class="form-control me-2" name="search" type="search" placeholder="Procurar Script" aria-label="Search">
                        <button class='sbuto' type="submit"><i class="fas fa-search"></i></button>
                      </form>
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
                  </div>
              </nav>
        </section>

        <section class="content">
                <div class="container">
                    <div class="content-body">
                    <div class="row">
                        <div class="col-md-8 text-center">
                            <p class="title">QUALIDADE EM CADA PEDIDO!</p>
                            <p class="stitle">DESEJA COMPRAR PRODUTOS EM NOSSA LOJA VIRTUAL?</p>
                            <a class="btn btn-logs my-5" href="#products"><i class="fas fa-arrow-circle-down"></i> Ver Produtos</a>
                        </div>
                        <div class="col-md-4 align-items-start">
                          <img src="app/img/bg.png">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="content" id="products">
          <div class="container">
              <div class="content-body2">
              <div class="row">
                  <div class="col-md-8 text-start">
                      <p class="title">NOSSOS MAPAS!</p>
                      <p class="stitle">CONFIRA NOSSOS SERVIÇOS!</p>
                  </div>
                  <div class="col-md-4 align-items-end">
                    <form action="">
                      <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                          Mais Recentes
                        </a>
                      
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                          <li><a class="dropdown-item" href="#">Maior Valor</a></li>
                          <li><a class="dropdown-item" href="#">Menor Valor</a></li>
                        </ul>
                      </div>
                    </form>

                  </div>
              </div>
          </div>

          <div class="products">
            <div class="row">
              <?php
              $queryP = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
              while($arrP = mysqli_fetch_assoc($queryP)){
                if($arrP['price'] < 1){
                  if(!isset($_COOKIE['hash']))
                  echo '<div class="col-md-3">
                <div class="card">
                  <p class="name">'.$arrP['title'].'</p>
                <p class="price">Grátis</p>
                <i class="fas fa-box-open"></i>
                <div class="container">
                  <a href="download.php?id='.$arrP['id'].'" class="btn btn-logs">Download</a>
                  <a href="script.php?id='.$arrP['id'].'" class="btn btn-log">Detalhes</a>
                </div>
                </div>
              </div>';
                }else{
                  echo '<div class="col-md-3">
                <div class="card">
                  <p class="name">'.$arrP['title'].'</p>
                <p class="price"><span>R$</span>'.$arrP['price'].',00</p>
                <i class="fas fa-box-open"></i>
                <div class="container">
                  <a href="gerar.php?id='.$arrP['id'].'" class="btn btn-logs">Comprar</a>
                  <a href="script.php?id='.$arrP['id'].'" class="btn btn-log">Detalhes</a>
                </div>
                </div>
              </div>';
                }
              }
              ?>
            </div>             
          </div>
      </div>
  </section>

  <section class="faq">
    <div class="container">
      <div class="row">
        <div class="col-md-3 text-start">
          <p class="title">Perguntas Frequentes!</p>
          <p class="stitle">Perguntas feitas frenquentemente em nossa loja!</p>
        </div>
      <div class="col-md-9">
        <div class="accordion" id="accordionExample">
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                TM STORE é confiável?
              </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <strong>Sim Somos confiáveis.</strong> Trabalhamos muito para que o cliente fique o mais feliz possível garantindo que seu script seja entregue 100% como pedido. Você também pode ver por meio de nossas <code>avaliações</code>! Se estiver em dúvida abra um ticket em nosso discord!
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Quais os métodos de pagamento?
              </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
              <div class="accordion-body">
               Trabalhamos com os mais diversos métodos de pagamento! Entre eles: <code>Mercado Pago</code>, <code>TED</code>, <code>PIX</code>, <code>Cartão Débito/Crédito</code>, e muito mais, se estiver em dúvida abra um ticket em nosso discord!
              </div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                Recebo suporte após a compra?
              </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
              <div class="accordion-body">
                <strong>Sim.</strong> Nosso suporte está sempre online para atender você em cada momento do dia! Se estiver em dúvida abra um ticket em nosso discord!
              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
  </section>

  <section class="avaliações">
    <div class="container text-center">
          <p class="title">Nossa equipe!</p>
          <p class="stitle">Aqui está a nossa equipe que faz a loja acontecer!</p>
          <div class="row my-5">
            <div class="col-md-6">
              <div class="card">
                <img src="app/img/Daniel.jpg">
                <p class="name">Daniel Silva</p>
                <p class="tags"><span class="badge bg-primary">Fundador</span> <span class="badge bg-primary">Desenvolvedor</span></p>
              </div>
            </div>
          </div>
    </div>
  </section>

  <section class="counter">
    <div class="container">
      <div class="row">
        <div class="col-md-4 text-center">
          <p class="title">Clientes</p>
          <p class="numbers">+<span class="number"><?php 
            $queryClients = mysqli_query($conn, "SELECT * FROM accounts");
            $numClients = mysqli_num_rows($queryClients) + 1;
            
            echo ''.$numClients.'';
          ?></span></p>
        </div>
        <div class="col-md-4 text-center">
          <p class="title">Produtos</p>
          <p class="numbers">+<span class="number"><?php 
            $queryClients = mysqli_query($conn, "SELECT * FROM products");
            $numClients = mysqli_num_rows($queryClients);
            
            echo ''.$numClients.'';
          ?></span></p>
        </div>
        <div class="col-md-4 text-center">
          <p class="title">Avaliações</p>
          <p class="numbers">+<span class="number">10</span></p>
        </div>
      </div>
    </div>
  </section>

  <section class="footer">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <img src="app/img/logo.png">
          <p class="copy">Todos os direitos reservados &copy; <script>document.write(new Date().getFullYear())</script> <br>Design by <a href="https://discord.gg/mmTfJx7V8C">Leinad Code</a></p>
        </div>
        <div class="col-md-6 text-end my-4">
          <a class="social" href="https://discord.gg/mmTfJx7V8C" target="_blank"><i class="fab fa-discord"></i></a>
          <a class="social" href="https://www.youtube.com/channel/UC4zocaahPTXDQEnm4IusWOQ" target="_blank"><i class="fab fa-youtube"></i></a>
          <a class="social" href="https://www.instagram.com/leinad_hosting/" target="_blank"><i class="fab fa-instagram"></i></a>
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