<?php
include('connessione_db.php');

if (!empty($_SESSION['carrello'])){
      ?> <div class="box-home"><h2>Carrello</h2> <?php

      if (isset($_POST['procedi'])) {
      header("location: checkout.php");
      }elseif (isset($_POST['home'])) {
      header("location: index.php");
      }else{
        $somma=0;
        $elemeti_del_carrello = count($_SESSION['carrello']);
        $carrello = $_SESSION['carrello'];
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

        ?>
          <br/><br/><br/><div class="box-cart">
          	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          		<h3>Totale</h3> <h4> <?php echo $somma +  "  €";?> <br /> </h4>
          		<input type="submit" class="button-cart" name="home" value="Torna alla Home" />
              <input type="submit" class="button-cart" name="procedi" value="Procedi con l'acqisto" />
          	</form>
          </div>
      	<?php
      }
  }else {
    echo 'Il carrello è vuoto.<br /><br /><a href="javascript:history.back();">Indietro</a>';
}

?>
