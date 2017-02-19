<?php
include('connessione_db.php');
if (empty($_SESSION['carrello'])) {
  $_SESSION['carrello'] = array();
}
array_push($_SESSION['carrello'], (INT)$_GET['id']);
header("Location: index.php")
?>
