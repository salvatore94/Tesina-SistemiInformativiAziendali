<!DOCTYPE html>
<html lang="en">
<!-- Bootstrap -->
<link rel="stylesheet" href="css/bootstrap.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Login</title>
<body>
<?php
include('connessione_db.php');

//Email dell'amministratore, utilizzata per abilitare i pannelli di amministrazione
//Ovviamente l'email dell'amministratore deve essere registrata anche nella tabella utenti del db
$admin_email = "admin@admin.it";

//Se già risulta un utente loggato questa pagina non deve essere accessibile
if(empty($_SESSION['email'])){
    if (isset($_POST['login'])) {
      $email = isset($_POST['email']) ? clear($_POST['email']) : false;
      $password = isset($_POST['password']) ? clear($_POST['password']) : false;

      if(empty($email) || empty($password)) {
        stampaAvviso("Riempi tutti i campi", "login.php");
    	} elseif(mysql_num_rows(mysql_query("SELECT * FROM utenti WHERE email LIKE '$email'")) == 0) {
    		stampaAvviso("Username non trovato", "login.php");
    	} else {
        //La password inserita deve essere criptata prima di effettuare la ricerca altrimenti non troveremmo mai corrispondeza
        $password = md5($password);
        if(mysql_num_rows(mysql_query("SELECT * FROM utenti WHERE email LIKE '$email' AND password='$password'")) > 0) {

          if ($email == $admin_email) {
            $_SESSION['email'] = "ADMIN";
          } else{
            $_SESSION['email'] = $email;
          }

          header("location: index.php");
        }else {
           stampaAvviso("Password errata", "login.php");
          }
      }
    } else {
      ?><div class="container">
        <div class="box">
          <h2>Login</h2><br/>
        	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
        		<input type="email" class="form-control" name="email" placeholder="Email" required maxlength="60" /><br/>
        		<input type="password" class="form-control" name="password" placeholder="Password" required maxlength="20" /><br/>
          </div>
          <div class="form-gruop" align=center>
            <input type="submit" class="btn btn-default" name="login" value="Accedi" />
          </div>
        </form><br/>
          <?php tornaAllaHomeinForm(); ?>
        </div>
      </div>
    	<?php
    }
} else {
  header("location: index.php");
}
?>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.js"></script>
</body>
</html>
