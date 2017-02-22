<?php
include('connessione_db.php');

if (!empty($_SESSION['email'])){
    //Per effettuare il logout basta distruggere la sessione
    session_destroy();
}
header("location: index.php");
?>
