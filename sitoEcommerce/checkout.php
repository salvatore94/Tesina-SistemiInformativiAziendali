<?php
include('connessione_db.php');

$path = "css/style.css";
include_once($path);
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
      echo 'Acquisto eseguito. <br /><br /><a href="index.php">Torna alla Home</a>';
    }elseif (isset($_POST['home'])) {
      header("location: index.php");
    } else{
      ?>
      <div class="box">
        <h2>Pagamento tramite PayPal</h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <label><input type="email" class="label" name="email" placeholder="Email"  maxlength="60" /></label><br />
          <label><input type="password" class="label" name="password" placeholder="Password"  maxlength="20" /></label><br /><br />
          <input type="submit" class="button" name="checkout" value="Esegui" />
          <input type="submit" class="button" name="home" value="Torna alla Home" />
        </form>
    </div>
      <?php
    }
}else{
  echo 'Il carrello è vuoto, impossibile procedere al pagamento.<br /><br /><a href="index.php">Torna alla Home</a>';
}
?>
