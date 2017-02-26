<?php
include('connessione_db.php');

$idProdotto = (INT)$_GET['idProdotto'];
$idCliente = (INT)$_GET['idCliente'];

$query = mysql_query("SELECT * FROM ordini WHERE idcliente='$idCliente' AND idprodotto='$idProdotto' AND pagato=false");

if (mysql_num_rows($query) > 0) {
  $query = mysql_query("SELECT id FROM ordini WHERE idcliente='$idCliente' AND idprodotto='$idProdotto'");
  $id = mysql_result($query, 0);

  $query = mysql_query("SELECT quantita FROM ordini WHERE id='$id'");
  $quantita = mysql_result($query, 0);
  $quantita = $quantita + 1;

  mysql_query("UPDATE ordini SET quantita='$quantita' WHERE id='$id'");
} else {

  mysql_query("INSERT INTO ordini (idcliente, idprodotto, quantita) VALUES ('$idCliente', '$idProdotto', 1)");

}

header("Location: carrello.php")
?>
