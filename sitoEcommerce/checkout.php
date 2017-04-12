<!DOCTYPE html>
<html lang="en">
<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Pagamento</title>
<body>
<?php
include('connessione_db.php');

  if (isset($_POST['checkout'])) {
    $idCliente = $_SESSION['userid'];
    $indirizzoSpedizione = isset($_POST['indirizzoSpedizione']) ? clear($_POST['indirizzoSpedizione']) : false;

    $query = mysql_query("SELECT * FROM ordini WHERE idcliente='$idCliente' AND pagato=false");
    $elementi_del_carrello = mysql_num_rows($query);

    for ($i=0; $i < $elementi_del_carrello; $i++) {
      $query = mysql_query("SELECT idprodotto FROM ordini WHERE idcliente='$idCliente' AND pagato=false");
      $idProdotto = mysql_result($query, $i);

      $query = mysql_query("SELECT quantita FROM ordini WHERE idcliente='$idCliente' AND pagato=false");
      $quantitaProdotto = mysql_result($query, $i);

      $query = mysql_query("SELECT quantita FROM prodotti WHERE id='$idProdotto'");
      $quantita = mysql_result($query, 0);

      if (($quantita - $quantitaProdotto) > 0) {
        $quantita = $quantita - $quantitaProdotto;

        mysql_query("UPDATE prodotti SET quantita='$quantita' WHERE id='$idProdotto'");
      } else {
        mysql_query("DELETE FROM prodotti WHERE id='$idProdotto'");
      }

      $query = mysql_query("SELECT id FROM ordini WHERE idcliente='$idCliente' AND idprodotto='$idProdotto'");
      $id = mysql_result($query, 0);
      mysql_query("UPDATE ordini SET pagato=true WHERE id='$id'");
      mysql_query("UPDATE ordini SET indirizzoSpedizione='$indirizzoSpedizione' WHERE id='$id'");
    }
      stampaAvviso("Acquisto eseguito", "index.php");
      creaPdfFattura();
  } else {
      ?>
      <div clas="container">
        <div class="box">
          <h2>Pagamento tramite PayPal</h2><br/><br/>
          <div class="form-group">
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="email" class="form-control" name="email" placeholder="Email" required maxlength="60" /><br/>
            <input type="password" class="form-control" name="password" placeholder="Password"  maxlength="20" /><br/>
            <input type="text" class="form-control" name="indirizzoSpedizione" placeholder="Indirizzo di spedizione"  maxlength="80" /><br/>
          <div class="form-group" align=center>
            <input type="submit" class="btn btn-default"  name="checkout" value="Esegui" />
          </div>
          </form>
          <br/>
          <?php tornaAllaHomeinForm(); ?>
        </div>
    </div>
<?php
  }

?>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>
