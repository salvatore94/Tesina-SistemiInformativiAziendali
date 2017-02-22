<?php
//La funzione clear($var) serve a "ripulire" le stringhe immesse nei vari form
function clear($var) {
	return addslashes(htmlspecialchars(trim($var)));
}

//La funzione creaTabellaHome() viene utilizzata per stampare in homepage una tabella contenente
//i vari articoli presenti nella tabella prodotti del db
//La riga di intestazione della tabella viene stampata  anche in assenza di elementi nella tabella prodotti del db

//Qualora ci sia un utente loggato nel sistema verrà presentato, nell'ultima colonna della tabella,
//il link per aggiungere al carrello il prodotto
function creaTabellaHome(){
echo "<table>
  <thead>
     <tr>
      	<th>Nome Prodotto</th>
      	<th>Codice</th>
      	<th>Quantità</th>
      	<th>Prezzo</th>
      	<th>Descrizione</th>
      	<th>Acquista</th>
    </tr>
  </thead>";


  	$risultati = mysql_query("SELECT * FROM prodotti");

  	while ($row = mysql_fetch_array($risultati)) {
  	 $codice = (int)$row["id"];
  		echo "<tr>
  		<td>".$row['nome']."</td>
      <td>".$row['codice']."</td>
  		<td>".$row['quantita']."</td>
  		<td>".$row['prezzo']."</td>
  		<td>".$row['descrizione']."</td>";
        if (isset($_SESSION['email'])){
  		    echo '<td><a href="aggiungi-al-carrello.php?id='.$codice.'">LINK</a></td>';
          } else {
          echo "<td></td>";
                 }
  		echo "</tr>";
  	    }

echo "</table>";
}

//La funzione creaTabellaCarrello() ha il duplice compito di stampare,
//sotto forma di tabella, la lista dei prodotti inseriti nel carrello e
//di calcolare l'importo totale della spesa
//L'importo totale verrà immagazzinato nella variabile $somma che a sua volta verrà restituita come risultato della funzione
function creaTabellaCarrello(){
  $carrello = $_SESSION['carrello'];
  $elemeti_del_carrello = count($carrello);
  $somma=0;
  $id=0;

  echo "<table>
  <thead>
    <tr>
      <th>Nome Prodotto</th>
      <th>Prezzo</th>
      <th>Rimuovi</th>
    </tr>
  </thead>";

  for($i=0; $i < $elemeti_del_carrello; $i++){
    $id = $carrello[$i];
    $risultati = mysql_query("SELECT * FROM prodotti WHERE id='$carrello[$i]'");
      while ($row = mysql_fetch_array($risultati)) {

          echo "<tr>
                  <td>".$row['nome']."</td>
                  <td>".$row['prezzo']."</td>";
                  echo '<td><a href="rimuovi-dal-carrello.php?id='.$i.'">Rimuovi</a></td>';
                  echo "</tr>";

                  $somma = $somma + $row['prezzo'];
          }
    }
  echo "</table></div>";

  return $somma;
}
?>
