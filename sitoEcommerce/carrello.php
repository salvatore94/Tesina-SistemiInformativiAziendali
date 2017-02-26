<!DOCTYPE html>
<html lang="en">
<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Carrello</title>
<body>
<?php
include("connessione_db.php");

if (!empty($_SESSION['email'])) {
  $idCliente = $_SESSION['userid'];
  $query = mysql_query("SELECT * FROM ordini WHERE idCliente='$idCliente'");
//  $elemeti_del_carrello = mysql_num_rows($query);
    if (mysql_num_rows($query) > 0){

                    ?><div class="container"> <div class="box-home"><h2>Carrello</h2> <?php

                    if (isset($_POST['procedi'])) {
                    header("location: checkout.php");
                    }else{

                      $somma = creaTabellaCarrello();

                      ?></div><br/><br/><br/>
                          <div class="box-cart">
                            <div class="form-group">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                          		<h3>Totale</h3> <div align=center><br/><?php echo "<label>$somma €</lebel>";?><br/></div>
                            </div>
                            <div class="form-group" align=center>
                              <input type="submit" class="btn btn-default" name="procedi" value="Procedi con l'acqisto" />
                          	</form><br/><br/>
                            <?php tornaAllaHomeinForm(); ?>
                            </div>
                          </div>
                        </div>
                    	<?php
                    }


      }else {
        stampaAvviso("Il carrello è vuoto", "index.php");
    }
} else {
  header("location: index.php");
}
?>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>
