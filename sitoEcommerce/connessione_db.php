<?php
//Questa pagina rappresenta il core del mio sistema, viene utilizzata per connettersi al database e
//creare (qualora non esistessero) le due tabelle necessarie al funzionamento del sito

//Importo i miei stili css
$path = "css/style.css";
include_once($path);

//Le funzioni sono implementate in un .php esterno per non appessantire il codice delle varie pagine
include("funzioni.php");

//Il funzionamento del sistema è basato su variabili di sessione
session_start();


$db_hostname = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'sitoecommerce';

$connect = mysql_connect($db_hostname, $db_username, $db_password);

if (!$connect){
  echo "Connessione non riuscita";
}else {
  mysql_select_db($db_name, $connect);
  mysql_query("CREATE TABLE IF NOT EXISTS utenti (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, email VARCHAR(60) NOT NULL, password VARCHAR(32) NOT NULL)");
  mysql_query("CREATE TABLE IF NOT EXISTS prodotti (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, nome VARCHAR(60) NOT NULL, codice INT NOT NULL, quantita INT NOT NULL, prezzo DOUBLE NOT NULL, descrizione VARCHAR(255))");
  mysql_query("CREATE TABLE IF NOT EXISTS ordini (id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, idcliente INT NOT NULL, idprodotto INT NOT NULL, quantita INT NOT NULL, pagato BOOLEAN NOT NULL DEFAULT false)");
}

?>
