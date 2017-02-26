<!DOCTYPE html>
<html lang="en">
<head>
<?php include("connessione_db.php"); ?>
<title>Sito eCommerce</title>
<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap.css">
</head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<body>
<nav>
  <div class="container">
    <div class="navbar-header">
      <h2 class="navbar-brand">Sito Ecommerce</h2>
    </div>
     <div class="collapse navbar-collapse">
			<?php
        if (empty($_SESSION['email'])) {
          stampaBottoniNavBar("Accedi", "login.php");
          stampaBottoniNavBar("Registrati", "registrazione.php");
				} else if(!empty($_SESSION['email'])) {
          stampaNomeUtente($_SESSION['email']);
          stampaBottoniNavBar("Esci", "logout.php");
          stampaBottoniNavBar("Carrello", "carrello.php");
					 if ($_SESSION['email'] == "ADMIN") {
             stampaBottoniNavBar("Aggiungi Prodotti", "aggiungi-prodotti.php");
             stampaBottoniNavBar("Rimuovi Prodotti", "rimuovi-prodotti.php");
             stampaBottoniNavBar("Lista Ordini", "ordini.php");
					}
				}
			?>
    </div>
  </div>
</nav>

<h2 class="text-center">Catalogo Prodotti</h2>
<hr>
<div class="container">
  <div class="box-home">
  <?php creaTabellaHome(); ?>
  </div>
</div>
<hr>
<div class="container">
  <div class="box-info">
          <strong>Salvatore Polito</strong><br>
  				<strong>Calogero Nicotra</strong><br>
          <br>
          Tesina di Sistemi Informativi Aziendali<br>
    </div>
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
