<?php
include('connessione_db.php');
//Questa pagina viene utilizzata dall'amministratore per aggiungere o modificare prodotti dell'inventario
//Quando l'amministratore effettua il login imposto la variabile  $_SESSION['email'] = "ADMIN" così mi basta
//effettuare il controllo su questa variabile per stabilire se l'utente ha accesso a questa pagina

//La rimozione del prodotto si basa sulla ricerca per codice.
//Se il codice inserito trova corrispondenza nella tabella prodotti utilizzo l'ID associato a quel codice prodotto
//per rimuovere la riga dalla tabella

if ($_SESSION['email'] != "ADMIN") {
      echo 'Sezione non autorizzata.<br /><br /><a href="javascript:history.back();">Indietro</a>';
} else {
    if (isset($_POST['rimuovi'])){
      $codice = isset($_POST['codice']) ? clear($_POST['codice']) : false;


      if(empty($codice)) {
    		echo 'Riempi il campo Codice Prodotto.<br /><br /><a href="javascript:history.back();">Indietro</a>';
    	} elseif (mysql_num_rows(mysql_query("SELECT * FROM prodotti WHERE codice='$codice'")) > 0) {
        $id = mysql_result(mysql_query("SELECT id FROM prodotti WHERE codice='$codice'"), 0);
        mysql_query("DELETE FROM prodotti WHERE id='$id'");
        header("Location: index.php");
      } else {
        echo 'Prodotto non trovato in catalogo.<br /><br /><a href="javascript:history.back();">Indietro</a>';
      }

    }elseif (isset($_POST['home'])) {
    header("location: index.php");
    }else {
      ?>
      <div class="box">
        <h2>Rimuovi Prodotto dal Catalogo </h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <label><input type="text" class="label" name="codice" placeholder="Codice Prodotto"  maxlength="60" /></label><br />
          <input type="submit" class="button" name="rimuovi" value="Rimuovi" />
          <input type="submit" class="button" name="home" value="Torna alla Home" />
        </form>
      </div>
      <?php
    }
}
?>
