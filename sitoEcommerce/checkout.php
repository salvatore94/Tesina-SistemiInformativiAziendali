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
    $query = mysql_query("SELECT * FROM ordini WHERE idCliente='$idCliente'");
    $elemeti_del_carrello = mysql_num_rows($query);

    for ($i=0; $i < $elemeti_del_carrello; $i++) {
      $query_id = mysql_query("SELECT idprodotto FROM ordini WHERE idCliente='$idCliente'");
      $query_quantita = mysql_query("SELECT quantita FROM ordini WHERE idCliente='$idCliente'");
      $idProdotto = mysql_result($query_id, $i);
      $quantitaProdotto = mysql_result($query_quantita, $i);

      $query = mysql_query("SELECT quantita FROM prodotti WHERE id='$idProdotto'");
      $quantita = mysql_result($query, 0);

      if (($quantita - $quantitaProdotto) > 0) {
        $quantita = $quantita - $quantitaProdotto;

        mysql_query("UPDATE prodotti SET quantita='$quantita' WHERE id='$idProdotto'");
      } else {
        mysql_query("DELETE FROM prodotti WHERE id='$idProdotto'");
      }

      $query = mysql_query("SELECT id FROM ordini WHERE idCliente='$idCliente' AND idprodotto='$idProdotto'");
      $id = mysql_result($query, 0);
      mysql_query("UPDATE ordini SET pagato=true WHERE id='$id'");

      stampaAvviso("Acquisto eseguito", "index.php");
    }
  } else {
      ?>
      <div clas="container">
        <div class="box">
          <h2>Pagamento tramite PayPal</h2><br/><br/>
          <div class="form-group">
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <input type="text" class="form-control" name="email" placeholder="Email" required maxlength="60" /><br/>
            <input type="text" class="form-control" name="password" placeholder="Password"  maxlength="20" /><br/>
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
