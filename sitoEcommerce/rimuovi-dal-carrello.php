<?php
include('connessione_db.php');
if (empty($_SESSION['carrello'])) {
  header("Location: index.php");
}

unset($_SESSION['carrello'][$_GET['id']]);
array_values();
header("Location: carrello.php");
?>
