<!DOCTYPE html>
<html lang="en">
<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Rimuovi Prodotti</title>
<body>
<?php
include('connessione_db.php');
//Questa pagina viene utilizzata dall'amministratore per aggiungere o modificare prodotti dell'inventario
//Quando l'amministratore effettua il login imposto la variabile  $_SESSION['email'] = "ADMIN" così mi basta
//effettuare il controllo su questa variabile per stabilire se l'utente ha accesso a questa pagina

//La rimozione del prodotto si basa sulla ricerca per codice.
//Se il codice inserito trova corrispondenza nella tabella prodotti utilizzo l'ID associato a quel codice prodotto
//per rimuovere la riga dalla tabella
if (empty($_SESSION['email']) || $_SESSION['email'] != "ADMIN") {
        stampaAvviso("Sezione non autorizzata", "index.php");
    } else {
        if (isset($_POST['rimuovi'])){
          $codice = isset($_POST['codice']) ? clear($_POST['codice']) : false;

          if (mysql_num_rows(mysql_query("SELECT * FROM prodotti WHERE codice='$codice'")) > 0) {
            $id = mysql_result(mysql_query("SELECT id FROM prodotti WHERE codice='$codice'"), 0);
            mysql_query("DELETE FROM prodotti WHERE id='$id'");
            stampaAvviso("Prodotto Rimosso", "rimuovi-prodotti.php");
          } else {
            stampaAvviso("Prodotto non trovato in catalogo", "rimuovi-prodotti.php");
          }

        }else {
          ?>
          <div clas="container">
            <div class="box">
              <h2>Rimuovi Prodotto dal Catalogo </h2><br/><br/>
              <div class="form-group">
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <input type="text" class="form-control" name="codice" placeholder="Codice Prodotto" required maxlength="11" /><br/>
              </div>
              <div class="form-group" align=center>
                <input type="submit" class="btn btn-default" name="rimuovi" value="Rimuovi" />
            </div>
            </form>
            <?php tornaAllaHomeinForm(); ?>
          </div>
        </div>
          <?php
        }
    }

?>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>
