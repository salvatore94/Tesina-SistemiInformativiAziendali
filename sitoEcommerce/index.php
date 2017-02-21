<!DOCTYPE html>
<html lang="it">
<head>
<?php include("connessione_db.php");

$path = "css/style.css";
include_once($path);

?>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Sito eCommerce </title>

<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap.css">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<nav>
  <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="#" >Sito Ecommerce</a>
    </div>
    <div class="collapse navbar-collapse">
			<?php

        if (!isset($_SESSION['userid'])) {
					echo '<ul class="nav navbar-nav navbar-right hidden-sm"><li><a href="login.php">Accedi</a></li></ul>';
					echo '<ul class="nav navbar-nav navbar-right hidden-sm"><li><a href="registrazione.php">Registrati</a></li></ul>';
				} else if(isset($_SESSION['userid'])) {
					echo '<ul class="nav navbar-nav navbar-right hidden-sm"><li>'; echo $_SESSION['email']; echo ' </li></ul>';
					echo '<ul class="nav navbar-nav navbar-right hidden-sm"><li><a href="logout.php">Esci</a></li></ul>';
          echo '<ul class="nav navbar-nav navbar-right hidden-sm"><li><a href="carrello.php">Carrello</a></li></ul>';
					if ($_SESSION['email'] == "ADMIN") {
						echo '<ul class="nav navbar-nav navbar-right hidden-sm"><li><a href="aggiungi-prodotti.php">Aggiungi Prodotti</a></li></ul>';
						echo '<ul class="nav navbar-nav navbar-right hidden-sm"><li><a href="rimuovi-prodotti.php">Rimuovi Prodotti</a></li></ul>';
					}
				}
			?>
    </div>
  </div>
</nav>

<h2 class="text-center">Catalogo Prodotti</h2>
<hr>
<div class="container">
<?php
	echo "<table>
  <thead>
    <tr>
	    <th>Nome Prodotto</th>
      <th>Codice</th>
	    <th>Quantità</th>
			<th>Prezzo</th>
	    <th>Descrizione</th>
      <th>Acquista</th>
	  </tr>
  </thead>";


	$risultati = mysql_query("SELECT * FROM prodotti");

	while ($row = mysql_fetch_array($risultati)) {
		  $codice = (int)$row["id"];
			echo "<tr>
							<td>".$row['nome']."</td>
              <td>".$row['codice']."</td>
			     		<td>".$row['quantita']."</td>
							<td>".$row['prezzo']."</td>
			  			<td>".$row['descrizione']."</td>";
							echo '<td><a href="aggiungi-al-carrello.php?id='.$codice.'">LINK</a></td>';
							echo "</tr>";

	}
	echo "</table>"
 ?>
</div>
<hr>
<div class="container well">
    <div class="row">
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-4">
      <address>
        <strong>Salvatore Polito</strong><br>
				<strong>Calogero Nicotra</strong><br>
        <br>
        Tesina di Sistemi Informativi Aziendali<br>
        </div>
    </div>
  </div>

<footer class="text-center">
  <div class="container">
      <div class="col-xs-12">
        <p>Copyright © MyWebsite. All rights reserved.</p>
    </div>
  </div>
</footer>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-1.11.3.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.js"></script>
</body>
</html>
