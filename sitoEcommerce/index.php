<!DOCTYPE html>
<html>
<head>
<?php
include("connessione_db.php");
include("funzioni.php");
?>
<title>Sito eCommerce </title>
<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap.css">
</head>

<body>
<nav>
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="#" >Sito Ecommerce</a>
    </div>
    <div class="collapse navbar-collapse">
			<?php
        if (!isset($_SESSION['email'])) {
					echo '<ul class="nav navbar-nav navbar-right"><li><a href="login.php">Accedi</a></li></ul>';
					echo '<ul class="nav navbar-nav navbar-right"><li><a href="registrazione.php">Registrati</a></li></ul>';
				} else if(isset($_SESSION['email'])) {
					echo '<ul class="nav navbar-nav navbar-right"><li>'; echo $_SESSION['email']; echo ' </li></ul>';
					echo '<ul class="nav navbar-nav navbar-right"><li><a href="logout.php">Esci</a></li></ul>';
          echo '<ul class="nav navbar-nav navbar-right"><li><a href="carrello.php">Carrello</a></li></ul>';
					 if ($_SESSION['email'] == "ADMIN") {
						echo '<ul class="nav navbar-nav navbar-right"><li><a href="aggiungi-prodotti.php">Aggiungi Prodotti</a></li></ul>';
						echo '<ul class="nav navbar-nav navbar-right"><li><a href="rimuovi-prodotti.php">Rimuovi Prodotti</a></li></ul>';
					}
				}
			?>
    </div>
  </div>
</nav>

<h2 class="text-center">Catalogo Prodotti</h2>
<hr>
<div class="box-home">
<?php
  creaTabellaHome();
?>
</div>
<hr>
<div class="box-info">
        <strong>Salvatore Polito</strong><br>
				<strong>Calogero Nicotra</strong><br>
        <br>
        Tesina di Sistemi Informativi Aziendali<br>
  </div>
<footer class="text-center">
        <br/>
        <p>Copyright © MyWebsite. All rights reserved.</p>
</footer>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>
