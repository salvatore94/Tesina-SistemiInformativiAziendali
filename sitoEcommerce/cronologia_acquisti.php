<!DOCTYPE html>
<html lang="en">
<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Ordini</title>
<body>
<?php
include('connessione_db.php');

if (empty($_SESSION['email'])) {
        stampaAvviso("Sezione non autorizzata", "index.php");
    } else {
      ?><div class="container">
          <div class="box-home"><h2>Lista Ordini</h2>
            <?php creaCronologiaAcquisti();?>
          </div><br/><br/><br/>

                <div class="box-cart" align=center>

                  <?php tornaAllaHomeinForm(); ?>
                  </div>
                </div>
            <?php
    }

?>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>
