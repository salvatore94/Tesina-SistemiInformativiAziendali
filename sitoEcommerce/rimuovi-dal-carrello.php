<?php
include('connessione_db.php');

$id = (int)$_GET['id'];
$query = mysql_query("SELECT quantita FROM ordini WHERE id='$id'");
$quantita = mysql_result($query, 0);

if($quantita > 1) {
  $quantita = $quantita - 1;

  mysql_query("UPDATE ordini SET quantita='$quantita' WHERE id='$id'");
} else {
  mysql_query("DELETE FROM ordini WHERE id='$id'");
}

header("Location: carrello.php");
?>
