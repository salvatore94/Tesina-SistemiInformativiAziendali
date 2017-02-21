<?php
include('connessione_db.php');
//Il carrello è un array contenente gli ID dei prodotti che vi si inseriscono
//l'ID rappresenta la chiave primaria nella tabella prodotti ed è un INT che si autoincrementa

//All'inizio della sessione $_SESSION['carrello'] non è definita perciò la inizializzo come array()
if (empty($_SESSION['carrello'])) {
  $_SESSION['carrello'] = array();
}

//Ogni volta che si vuole aggiungere un prodotto al carrello bisogna aprire questa pagina
//passando l'ID del prodotto stesso.
//Leggiamo l'ID tramite la variabile $_GET['id'] ed usiamo la funzione array_push() per inserire
//questo valore all'interno dell'array.
array_push($_SESSION['carrello'], (INT)$_GET['id']);
header("Location: carrello.php")
?>
