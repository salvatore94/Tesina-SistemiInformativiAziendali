<?php
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
