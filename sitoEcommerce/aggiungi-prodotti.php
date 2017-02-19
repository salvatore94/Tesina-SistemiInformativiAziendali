<?php
include('connessione_db.php');
echo "<style>
.login {
  padding: 40px;
  width: 274px;
  background-color: #F7F7F7;
  margin: 0 auto 10px;
  border-radius: 2px;
  box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
  }
.login-button {
    width: 100%;
    display: block;
    margin-bottom: 10px;
    position: relative;
  }
.login-label {
    height: 44px;
    font-size: 16px;
    width: 100%;
    margin-bottom: 10px;
    -webkit-appearance: none;
    background: #fff;
    border: 1px solid #d9d9d9;
    border-top: 1px solid #c0c0c0;
    /* border-radius: 2px; */
    padding: 0 8px;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
  }

  </style>";
if (isset($_POST['inserisci'])){
  $nome = isset($_POST['nome']) ? clear($_POST['nome']) : false;
  $quantita = isset($_POST['quantita']) ? clear($_POST['quantita']) : false;
  $descrizione = isset($_POST['descrizione']) ? clear($_POST['descrizione']) : false;
  $prezzo = isset($_POST['prezzo']) ? clear($_POST['prezzo']) : false;

  if(empty($nome) || empty($prezzo) || empty($quantita)) {
		echo 'Riempi il campo nome ed il campo quantità.<br /><br /><a href="javascript:history.back();">Indietro</a>';
	} elseif (mysql_num_rows(mysql_query("SELECT * FROM prodotti WHERE nome LIKE '$nome'")) > 0) {
    $id = mysql_result(mysql_query("SELECT id FROM prodotti WHERE nome LIKE '$nome'"), 0);
      if(empty($descrizione)){
        mysql_query("UPDATE prodotti SET quantita = '$quantita', prezzo = '$prezzo' WHERE id='$id'");
      } else {
        mysql_query("UPDATE prodotti SET quantita = '$quantita', prezzo = '$prezzo', descrizione = '$descrizione' WHERE id='$id'");
      }
  } elseif (empty($descrizione)) {
    mysql_query("INSERT INTO prodotti (nome, quantita, prezzo) VALUES ('$nome', '$quantita', '$prezzo')");
  } else {
    mysql_query("INSERT INTO prodotti (nome, quantita, prezzo, descrizione) VALUES ('$nome', '$quantita', '$prezzo', '$descrizione')");
  }
  header("Location: index.php");
}else {
  ?>
  <div class="login">
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <label><input type="text" class="login-label" name="nome" placeholder="Nome Prodotto" required maxlength="60" /></label><br />
    <label><input type="text" class="login-label" name="quantita" placeholder="Quantità disponibile" required maxlength="11" /></label><br />
    <label><input type="text" class="login-label" name="prezzo" placeholder="Prezzo" required maxlength="11" /></label><br />
    <label><input type="text" class="login-label" name="descrizione" placeholder="Descrizione"  maxlength="255" /></label><br />
    <input type="submit" class="login-button" name="inserisci" value="Inserisci" />
  </form>
  </div>
  <?php
}
?>
