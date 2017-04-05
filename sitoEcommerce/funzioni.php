<?php
include("creazione_pdf.php");
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
?>
	<table>
	  <thead>
	     <tr>
	      	<th><label>Nome Prodotto</label></th>
	      	<th><label>Codice</label></th>
	      	<th><label>Quantità</label></th>
	      	<th><label>Prezzo</label></th>
	      	<th><label>Descrizione</label></th>
	      	<th><label>Acquista</label></th>
	    </tr>
	  </thead>
<?php

  	$risultati = mysql_query("SELECT * FROM prodotti");

  	while ($row = mysql_fetch_array($risultati)) {
  	 $codice = (int)$row['id'];
		 $prezzo = $row['prezzo'];
	?>
		<tr>
			<td><div style='padding: 8px' ><label><?php echo $row['nome']; ?></label></div></td>
      <td><label><?php echo $row['codice']; ?></label></td>
  		<td><label><?php echo $row['quantita']; ?></label></td>
  		<td><label><?php echo "$prezzo €"; ?></label></td>
  		<td><label><?php echo $row['descrizione']; ?><label></td>
		<?php
        if (isset($_SESSION['email'])){
					$idCliente = (int)$_SESSION['userid'];
  		    ?> <td><label><a href="aggiungi-al-carrello.php?idCliente=<?php echo $idCliente; ?>&idProdotto=<?php echo $codice; ?>">LINK</a></label></td><?php
          } else {
          ?><td></td><?php
                 }
  		?></tr><?php
  	    }

?></table><?php
}

//La funzione creaTabellaCarrello() ha il duplice compito di stampare,
//sotto forma di tabella, la lista dei prodotti inseriti nel carrello e
//di calcolare l'importo totale della spesa
//L'importo totale verrà immagazzinato nella variabile $somma che a sua volta verrà restituita come risultato della funzione
function creaTabellaCarrello(){
	$idCliente = $_SESSION['userid'];
	$query = mysql_query("SELECT * FROM ordini WHERE idCliente='$idCliente' AND pagato=false");
  $elemeti_del_carrello = mysql_num_rows($query);

  $somma=0;

	?>
		<table>
		  <thead>
		    <tr>
		      <th><label>Nome Prodotto</label></th>
		      <th><label>Prezzo</label></th>
					<th><label>Quantità</label></th>
		      <th><label>Rimuovi</label></th>
		    </tr>
		  </thead>
	<?php

  for($i=0; $i < $elemeti_del_carrello; $i++){
		$query = mysql_query("SELECT idProdotto FROM ordini WHERE idCliente='$idCliente'");
		$idProdotto = mysql_result($query, $i);

		$query = mysql_query("SELECT id FROM ordini WHERE idCliente='$idCliente'");
		$idOrdine = mysql_result($query, $i);

		$query = mysql_query("SELECT quantita FROM ordini WHERE idCliente='$idCliente'");
		$quantita = mysql_result($query, $i);

    	$risultati = mysql_query("SELECT * FROM prodotti WHERE id='$idProdotto'");
      while ($row = mysql_fetch_array($risultati)) {
				$prezzo = $row['prezzo'];

					?><tr>
								<td><div style='padding: 8px' ><label><?php echo $row['nome']; ?></label></div></td>
								<td><label><?php echo "$prezzo €"; ?></label></td>
								<td><label><?php echo $quantita; ?></label></td>
								<td><a href="rimuovi-dal-carrello.php?id=<?php echo $idOrdine; ?>">Rimuovi</a></td>
								</tr>
						<?php

						$prezzo = $prezzo * $quantita;
						$somma = $somma + $prezzo;
          }
    }
  ?></table><?php

  return $somma;
}

function creaTabellaOrdini(){

	?>
		<table>
		  <thead>
		    <tr>
		      <th><label>Email Cliente</label></th>
		      <th><label>ID Prodotto</label></th>
					<th><label>Quantità</label></th>
		    </tr>
		  </thead>
	<?php

		$risultati = mysql_query("SELECT * FROM ordini WHERE pagato=true");
      while ($row = mysql_fetch_array($risultati)) {
				$idCliente = $row['idcliente'];
				$idProdotto = $row['idprodotto'];
				$quantita = $row['quantita'];

				$query = mysql_query("SELECT email FROM utenti WHERE id='$idCliente'");
				$email = mysql_result($query, 0);

				$query = mysql_query("SELECT codice FROM prodotti WHERE id='$idProdotto'");
				$codice = mysql_result($query, 0);


				?>
					<tr>
						<td><div style="padding: 8px" ><label><?php echo $email; ?></label></div></td>
						<td><label><?php echo $codice; ?></label></td>
						<td><label><?php echo $quantita; ?></label></td>
					</tr>
			<?php
			}
	?></table><?php
}

function creaCronologiaAcquisti() {
	?>
		<table>
			<thead>
				<tr>
					<th><label>Nome Prodotto</label></th>
					<th><label>Quantità</label></th>
					<th><label>Indirizzo di Spedizione</label></th>
				</tr>
			</thead>

	<?php

	$id = $_SESSION['userid'];
	$risultati = mysql_query("SELECT * FROM ordini WHERE idCliente='$id' and pagato=true");
		while ($row = mysql_fetch_array($risultati)) {
			$idProdotto = $row['idprodotto'];
			$quantita = $row['quantita'];
			$indirizzoSpedizione = $row['indirizzoSpedizione'];

			$query = mysql_query("SELECT nome FROM prodotti WHERE id='$idProdotto'");
			$nomeProdotto = mysql_result($query, 0);

			?>
				<tr>
					<td><div style="padding: 8px" ><label><?php echo $nomeProdotto; ?></label></div></td>
					<td><label><?php echo $quantita; ?></label></td>
					<td><label><?php echo $indirizzoSpedizione; ?></label></td>
				</tr>
		<?php
		}
?></table><?php
}

function emptyCart(){
	$idCliente = $_SESSION['userid'];
	$query = mysql_query("SELECT * FROM ordini WHERE idCliente='$idCliente' AND pagato=false");
	if (mysql_num_rows($query) == 0){
		return true;
	}
	return false;
}

function stampaBottoniNavBar($testo, $url){
?>
		<ul class="nav navbar-nav navbar-right btn">
			<li>
				<a class="nav navbar-nav navbar-right" href="<?php echo $url;?>"><?php echo $testo; ?></a>
			</li>
		</ul>
<?php
}

function stampaNomeUtente($email){
	?><span class="navbar-text navbar-center"><?php echo $email; ?></span><?php
}

function tornaAllaHomeinForm(){
?>
<div class="form-group" align=center>
		<form action="index.php">
			<input type="submit" class="btn btn-default" value="Torna alla Home" />
		</form>
	</div>
<?php
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

function creaPdfFattura() {
	$idCliente = $_SESSION['userid'];
	$query = mysql_query("SELECT * FROM ordini WHERE idCliente='$idCliente' AND pagato=true");
	$elementi_del_carrello = mysql_num_rows($query);

	$subtotale = 0;
	$totale = 0;

  $pdf = new PDF();

    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Times','',12);
    $pdf->SetTextColor(32);
    $pdf->Cell(0,5,"sitoEcommerce",0,1,'R');
    $pdf->Cell(0,5,"Universita degli Studi di Palermo",0,1,'R');
    $pdf->Cell(0,5,"sitoEcommerce@unipa.it",0,1,'R');
    $pdf->Cell(0,30,'',0,1,'R');
    $pdf->SetFillColor(200,220,255);
    $pdf->ChapterTitle('Numero di Fattura ',rand(20, 250));
    $pdf->ChapterTitle('Data ',date('d-m-Y'));
    $pdf->Cell(0,20,'',0,1,'R');
    $pdf->SetFillColor(224,235,255);
    $pdf->SetDrawColor(192,192,192);
    $pdf->Cell(170,7,'Articolo',1,0,'L');
    $pdf->Cell(20,7,'Prezzo',1,1,'C');
		for ($i=0; $i < $elementi_del_carrello; $i++) {
			$query = mysql_query("SELECT idprodotto FROM ordini WHERE idCliente='$idCliente'");
      $idProdotto = mysql_result($query, $i);

      $query = mysql_query("SELECT quantita FROM ordini WHERE idCliente='$idCliente'");
      $quantitaProdotto = mysql_result($query, $i);

			$query = mysql_query("SELECT prezzo FROM prodotti WHERE id='$idProdotto'");
      $prezzo = mysql_result($query, 0);

			$query = mysql_query("SELECT nome FROM prodotti WHERE id='$idProdotto'");
			$nomeProdotto = mysql_result($query, 0);

    	$pdf->Cell(170,7,$nomeProdotto,1,0,'L',0);
    	$pdf->Cell(20,7,$prezzo * $quantitaProdotto,1,1,'C',0);

			$subtotale = $subtotale + ($prezzo * $quantitaProdotto);
		}
    $pdf->Cell(0,0,'',0,1,'R');
    $pdf->Cell(170,7,'Iva',1,0,'R',0);

		$iva = (($subtotale * 22) / 100);
    $pdf->Cell(20,7,$iva,1,1,'C',0);

		$totale = $subtotale + $iva;
    $pdf->Cell(170,7,'Totale',1,0,'R',0);
    $pdf->Cell(20,7,$totale,1,0,'C',0);
    $pdf->Cell(0,20,'',0,1,'R');

		$query = mysql_query("SELECT indirizzoSpedizione FROM ordini WHERE idCliente='$idCliente' AND pagato=true");
		$indirizzoSpedizione = mysql_result($query, 0);
    $pdf->Cell(0,5,"Indirizzo di Spedizione",0,1,'L');
    $pdf->Cell(0,5,$indirizzoSpedizione,0,1,'L');


    $filename="fattura.pdf";
    $pdf->Output($filename,'F');
}
?>
