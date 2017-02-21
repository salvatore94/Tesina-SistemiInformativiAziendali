<?php
include('connessione_db.php');

$path = "css/style.css";
include_once($path);

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
?>
