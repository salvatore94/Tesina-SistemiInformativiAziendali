<?php
include('connessione_db.php');
echo "<style>
table {
    border-spacing: 5px;
		width: 60%;

}

</style>";
if (!empty($_SESSION['carrello'])){
      $elemeti_del_carrello = count($_SESSION['carrello']);
      $carrello = $_SESSION['carrello'];
      $id=0;
      if (isset($_POST['checkout'])) {
        for($i=0; $i < $elemeti_del_carrello; $i++){

        $id = $carrello[$i];
        $query = mysql_query("SELECT quantita FROM prodotti WHERE id='$id'");
        $quantita_precedente = mysql_result($query, 0);
        $quantita = $quantita_precedente - 1;

        if ($quantita > 0 ) {
        mysql_query("UPDATE prodotti SET quantita = '$quantita' WHERE id='$id'");
      } else {
        mysql_query("DELETE FROM prodotti WHERE id='$id'");
      }
    }
     $_SESSION['carrello'] = array();
      header("location: index.php");
       }else{
      $somma=0;
      echo "<table>
        <tr>
          <th>Nome Prodotto</th>
          <th>Prezzo</th>
          <th>Rimuovi</th>
        </tr>";

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
      echo "</table>";

      ?>
      <div class="login">
    	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    		<br /><br /><label>Totale : </label>
    		<label> <?php echo $somma; echo " €     "; ?> </label>
    		<input type="submit" class="login-button" name="checkout" value="Procedi con l'acqisto" />
    	</form>
      </div>
    	<?php
    }
}else {
  echo 'Il carrello è vuoto.<br /><br /><a href="javascript:history.back();">Indietro</a>';
}

?>
