<?php
include('connessione_db.php');
//Questa pagina viene utilizzata dall'amministratore per aggiungere o modificare prodotti dell'inventario
//Quando l'amministratore effettua il login imposto la variabile  $_SESSION['email'] = "ADMIN" così mi basta
//effettuare il controllo su questa variabile per stabilire se l'utente ha accesso a questa pagina

//Se l'amministratore inserisce il codice di un prodotto già registrato, il sistema aggiorna i campi quantità e descrizione
//di questo prodotto con i valori inseriti, altrimenti crea un nuovo prodotto
//Il campo descrizione è opzionale (e può essere aggiornato in seguito) mentre i campi nome, codice, prezzo, quantità sono obbligatori:
//il sistema rimanda ad una pagina d'errore se omessi
if ($_SESSION['email'] != "ADMIN") {
      echo 'Sezione non autorizzata.<br /><br /><a href="javascript:history.back();">Indietro</a>';
} else {
    if (isset($_POST['inserisci'])){
      $nome = isset($_POST['nome']) ? clear($_POST['nome']) : false;
      $codice = isset($_POST['codice']) ? clear($_POST['codice']) : false;
      $quantita = isset($_POST['quantita']) ? clear($_POST['quantita']) : false;
      $descrizione = isset($_POST['descrizione']) ? clear($_POST['descrizione']) : false;
      $prezzo = isset($_POST['prezzo']) ? clear($_POST['prezzo']) : false;

        if(empty($nome) || empty($prezzo) || empty($quantita) || empty($codice)) {
      		echo 'Riempi il campo nome, il campo codice, il campo quantità ed il campo prezzo.<br /><br /><a href="javascript:history.back();">Indietro</a>';
      	} elseif (mysql_num_rows(mysql_query("SELECT * FROM prodotti WHERE codice='$codice'")) > 0) {
          $id = mysql_result(mysql_query("SELECT id FROM prodotti WHERE codice='$codice'"), 0);
            if(empty($descrizione)){
              mysql_query("UPDATE prodotti SET quantita = '$quantita', prezzo = '$prezzo' WHERE id='$id'");
            } else {
              mysql_query("UPDATE prodotti SET quantita = '$quantita', prezzo = '$prezzo', descrizione = '$descrizione' WHERE id='$id'");
            }
        } elseif (empty($descrizione)) {
          mysql_query("INSERT INTO prodotti (nome, codice, quantita, prezzo) VALUES ('$nome', '$codice', '$quantita', '$prezzo')");
        } else {
          mysql_query("INSERT INTO prodotti (nome, codice, quantita, prezzo, descrizione) VALUES ('$nome', '$codice', '$quantita', '$prezzo', '$descrizione')");
        }
      header("Location: index.php");
    } elseif (isset($_POST['home'])) {
      header("location: index.php");
    } else {
      ?>

      <div class="box">
        <h2>Aggiungi Prodotto dal Catalogo </h2>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          <label><input type="text" class="label" name="nome" placeholder="Nome Prodotto"  maxlength="60" /></label><br />
          <label><input type="text" class="label" name="codice" placeholder="Codice Prodotto"  maxlength="11" /></label><br />
          <label><input type="text" class="label" name="quantita" placeholder="Quantità disponibile"  maxlength="11" /></label><br />
          <label><input type="text" class="label" name="prezzo" placeholder="Prezzo"  maxlength="11" /></label><br />
          <label><input type="text" class="label" name="descrizione" placeholder="Descrizione"  maxlength="255" /></label><br />
          <input type="submit" class="button" name="inserisci" value="Inserisci" />
          <input type="submit" class="button" name="home" value="Torna alla Home" />
        </form>
      </div>
      <?php
    }
}
?>
