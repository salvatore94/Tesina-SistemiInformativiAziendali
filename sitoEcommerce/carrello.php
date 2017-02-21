<?php
include("connessione_db.php");
include("funzioni.php");

if (!empty($_SESSION['carrello'])){
      ?> <div class="box-home"><h2>Carrello</h2> <?php

      if (isset($_POST['procedi'])) {
      header("location: checkout.php");
      }elseif (isset($_POST['home'])) {
      header("location: index.php");
      }else{

        $somma = creaTabellaCarrello();

        ?>
          <br/><br/><br/><div class="box-cart">
          	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
          		<h3>Totale</h3> <h4> <?php echo $somma +  '  €';?> <br /> </h4>
          		<input type="submit" class="button-cart" name="home" value="Torna alla Home" />
              <input type="submit" class="button-cart" name="procedi" value="Procedi con l'acqisto" />
          	</form>
          </div>
      	<?php
      }
  }else {
    echo 'Il carrello è vuoto.<br /><br /><a href="index.php">Torna alla Home</a>';
}

?>
