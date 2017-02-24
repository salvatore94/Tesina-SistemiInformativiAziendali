<!DOCTYPE html>
<html lang="en">
<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Aggiungi Prodotto</title>
<body>
<?php
include('connessione_db.php');
//Questa pagina viene utilizzata dall'amministratore per aggiungere o modificare prodotti dell'inventario
//Quando l'amministratore effettua il login imposto la variabile  $_SESSION['email'] = "ADMIN" così mi basta
//effettuare il controllo su questa variabile per stabilire se l'utente ha accesso a questa pagina

//Se l'amministratore inserisce il codice di un prodotto già registrato, il sistema aggiorna i campi quantità e descrizione
//di questo prodotto con i valori inseriti, altrimenti crea un nuovo prodotto
//Il campo descrizione è opzionale (e può essere aggiornato in seguito) mentre i campi nome, codice, prezzo, quantità sono obbligatori:
//il sistema rimanda ad una pagina d'errore se omessi
if (!empty($_SESSION['email']) || $_SESSION['email'] != "ADMIN") {
        if (isset($_POST['inserisci'])){
          $nome = isset($_POST['nome']) ? clear($_POST['nome']) : false;
          $codice = isset($_POST['codice']) ? clear($_POST['codice']) : false;
          $quantita = isset($_POST['quantita']) ? clear($_POST['quantita']) : false;
          $descrizione = isset($_POST['descrizione']) ? clear($_POST['descrizione']) : false;
          $prezzo = isset($_POST['prezzo']) ? clear($_POST['prezzo']) : false;

            if (mysql_num_rows(mysql_query("SELECT * FROM prodotti WHERE codice='$codice'")) > 0) {
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

          stampaAvviso("Prodotto Aggiunto", "aggiungi-prodotti.php");
        } else {
          ?>
          <div clas="container">
            <div class="box">
              <h2>Aggiungi Prodotto dal Catalogo </h2><br/><br/>
              <div class="form-group">
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <input type="text" class="form-control" name="nome" placeholder="Nome Prodotto" required maxlength="60" /><br/>
                <input type="number" class="form-control" name="codice" placeholder="Codice Prodotto" required maxlength="11" /><br/>
                <input type="text" class="form-control" name="quantita" placeholder="Quantità disponibile" required maxlength="11" /><br/>
                <input type="text" class="form-control" name="prezzo" placeholder="Prezzo" required maxlength="11" /><br/>
                <input type="text" class="form-control" name="descrizione" placeholder="Descrizione"  maxlength="255" /><br/>
              </div>
              <div class="form-group" align=center>
                <input type="submit" class="btn btn-default"  name="inserisci" value="Inserisci" />
              </div>
              </form>
            <?php tornaAllaHomeinForm(); ?>
            </div>
        </div>
          <?php
        }
    
} else {
  stampaAvviso("Sezione non autorizzata", "index.php");
}
?>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>
