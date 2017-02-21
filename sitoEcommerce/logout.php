<?php
include('connessione_db.php');

//Per effettuare il logout basta distruggere la sessione
session_destroy();

header("location: index.php");
?>
