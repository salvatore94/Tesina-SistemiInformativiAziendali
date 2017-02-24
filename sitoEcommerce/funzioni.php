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
	      	<th><label>Nome Prodotto</label></th>
	      	<th><label>Codice</label></th>
	      	<th><label>Quantità</label></th>
	      	<th><label>Prezzo</label></th>
	      	<th><label>Descrizione</label></th>
	      	<th><label>Acquista</label></th>
	    </tr>
	  </thead>";


  	$risultati = mysql_query("SELECT * FROM prodotti");

  	while ($row = mysql_fetch_array($risultati)) {
  	 $codice = (int)$row["id"];
  		echo "<tr>
			<td><div style='padding: 8px' ><label>".$row['nome']."</label></div></td>
      <td><label>".$row['codice']."</label></td>
  		<td><label>".$row['quantita']."</label></td>
  		<td><label>".$row['prezzo']." €</label></td>
  		<td><label>".$row['descrizione']."<label></td>";
        if (isset($_SESSION['email'])){
  		    echo '<td><label><a href="aggiungi-al-carrello.php?id='.$codice.'">LINK</a></label></td>';
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
      <th><label>Nome Prodotto</label></th>
      <th><label>Prezzo</label></th>
      <th><label>Rimuovi</label></th>
    </tr>
  </thead>";

  for($i=0; $i < $elemeti_del_carrello; $i++){
    $id = $carrello[$i];
    $risultati = mysql_query("SELECT * FROM prodotti WHERE id='$carrello[$i]'");
      while ($row = mysql_fetch_array($risultati)) {

					echo "<tr>
									<td><div style='padding: 8px' ><label>".$row['nome']."</label></div></td>
									<td><label>".$row['prezzo']." €</label></td>
									<td><a href='rimuovi-dal-carrello.php?id='.$i.''>Rimuovi</a></td>
								</tr>";

                  $somma = $somma + $row['prezzo'];
          }
    }
  echo "</table>";

  return $somma;
}
function stampaBottoniNavBar($testo, $url){
		echo '<ul class="nav navbar-nav navbar-right btn"><li><a class="nav navbar-nav navbar-right" href='.$url.'>'.$testo.'</a></li></ul>';
}

function stampaNomeUtente($email){
	echo '<span class="navbar-text navbar-center">'.$email.'</span>';
}

function tornaAllaHomeinForm(){
	echo
'	<div class="form-group" align=center>
		<form action="index.php">
			<input type="submit" class="btn btn-default" value="Torna alla Home" />
		</form>
	</div>';
}

function stampaAvviso($testo, $url){

	?>
	<div class="container">
		<div class="box-info">
			<h2><?php echo $testo; ?></h2><br/><br/>
			<form action="<?php echo $url;?>">
    		<input type="submit" class="btn btn-default" value="Indietro" />
			</form>
		</div>
	</div>
 <?php
}
?>
