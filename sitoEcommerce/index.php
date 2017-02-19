<!DOCTYPE html>
<html lang="it">
<head>
<?php include("connessione_db.php");
echo "<style>
table {
    border-spacing: 5px;
		width: 90%;

}
</style>";
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

    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <a class="navbar-brand" href="#">Sito Ecommerce</a> </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse">
<ul class="nav navbar-nav">
        <li class="active"> </li>
        <li> </li>
      </ul>
      <form class="navbar-form navbar-right" role="search">
      </form>
			<?php

        if (!isset($_SESSION['userid'])) {
					echo '<ul class="nav navbar-nav navbar-right hidden-sm"><li><a href="login.php">Accedi</a></li></ul>';
					echo '<ul class="nav navbar-nav navbar-right hidden-sm"><li><a href="registrazione.php">Registrati</a></li></ul>';
				} else if(isset($_SESSION['userid'])) {
					echo '<ul class="nav navbar-nav navbar-right hidden-sm"><li>'; echo $_SESSION['email']; echo ' </li></ul>';
					echo '<ul class="nav navbar-nav navbar-right hidden-sm"><li><a href="logout.php">Esci</a></li></ul>';
					if ($_SESSION['email'] == "ADMIN") {
						echo '<ul class="nav navbar-nav navbar-right hidden-sm"><li><a href="aggiungi-prodotti.php">Aggiungi Prodotti</a></li></ul>';
						echo '<ul class="nav navbar-nav navbar-right hidden-sm"><li><a href="rimuovi-prodotti.php">Rimuovi Prodotti</a></li></ul>';
					}
				}
			?>
      <ul class="nav navbar-nav navbar-right hidden-sm">
        <li><a href="carrello.php">Carrello</a></li>
      </ul>
    </div>
    <!-- /.navbar-collapse -->
  </div>
  <!-- /.container-fluid -->
</nav>
<hr>
<h2 class="text-center">Catalogo Prodotti</h2>
<hr>
<div class="container">
<?php
	echo "<table>
		<tr>
	    <th>Nome Prodotto</th>
	    <th>Quantità</th>
			<th>Prezzo</th>
	    <th>Descrizione</th>
			<th>Aggiungi al Carrello</th>
	  </tr>";


	$risultati = mysql_query("SELECT * FROM prodotti");

	while ($row = mysql_fetch_array($risultati)) {
		  $codice = (int)$row["id"];
			echo "<tr>
							<td>".$row['nome']."</td>
			     		<td>".$row['quantita']."</td>
							<td>".$row['prezzo']."</td>
			  			<td>".$row['descrizione']."<td>";
							echo '<td><a href="aggiungi-al-carrello.php?id='.$codice.'">link</a></td>';
							echo "</tr>";

	}
	echo "</table>"
 ?>
</div>
<hr>
<hr>
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
    <div class="row">
      <div class="col-xs-12">
        <p>Copyright © MyWebsite. All rights reserved.</p>
      </div>
    </div>
  </div>
</footer>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-1.11.3.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.js"></script>
</body>
</html>