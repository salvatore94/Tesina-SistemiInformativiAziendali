<!DOCTYPE html>
<html lang="en">
<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Pagamento</title>
<body>
<?php
include('connessione_db.php');

//Simulazione del pagamento

//Una volta completato il pagamento è necessario rimuovere i prodotti acquistati dall'inventario:
//per fare ciò controllo la quantità che era disponibile prima dell'acquisto e vi sottraggo 1 (tolgo il prodotto acquistato)
//se il valore trovato è >0 lo utilizzo per aggiornare la quantità disponibile altrimenti rimuovo dal catalogo il prodotto

//Andato a buon fine l'aggiornamento del db, inizializzo il carrello reimpostando la variabile $_SESSION['carrello']
if (!empty($_SESSION['email'])){
    if (!empty($_SESSION['carrello'])){
        if (isset($_POST['checkout'])) {
          $elemeti_del_carrello = count($_SESSION['carrello']);
          $carrello = $_SESSION['carrello'];
          $id=0;
          $email = isset($_POST['email']) ? clear($_POST['email']) : false;
          $password = isset($_POST['password']) ? clear($_POST['password']) : false;

            for($i=0; $i < $elemeti_del_carrello; $i++){

              $id = $carrello[$i];
              $query = mysql_query("SELECT quantita FROM prodotti WHERE id='$id'");
              $quantita_precedente = mysql_result($query, 0);
              $quantita = $quantita_precedente - 1;

                if ($quantita > 0 ) {
                  mysql_query("UPDATE prodotti SET quantita = '$quantita' WHERE id='$id'");
                } else {
                  mysql_query("DELETE FROM prodotti WHERE id='$id'");
                }
            }

          $_SESSION['carrello'] = array();
          stampaAvviso("Acquisto eseguito", "index.php");
        }elseif (isset($_POST['home'])) {
          header("location: index.php");
        } else{
          ?>
          <div clas="container">
            <div class="box">
              <h2>Pagamento tramite PayPal</h2><br/><br/>
              <div class="form-group">
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <input type="text" class="form-control" name="email" placeholder="Email"  maxlength="60" /><br/>
                <input type="text" class="form-control" name="password" placeholder="Password"  maxlength="20" /><br/>
              <div class="form-group" align=center>
                <input type="submit" class="btn btn-default"  name="checkout" value="Esegui" />
                <input type="submit" class="btn btn-default" name="home" value="Torna alla Home" />
              </div>
              </form>
            </div>
        </div>
      <?php
        }
    }else{
      stampaAvviso("Il carrello è vuoto, impossibile procedere al pagamento", "index.php");
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
