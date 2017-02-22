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
    		echo 'Riempi tutti i campi.<br /><br /><a href="javascript:history.back();">Indietro</a>';
    	} elseif(mysql_num_rows(mysql_query("SELECT * FROM utenti WHERE email LIKE '$email'")) == 0) {
    		echo 'Username non trovato.<br /><br /><a href="javascript:history.back();">Indietro</a>';
    	} else {
        //La password inserita deve essere criptata prima di effettuare la ricerca altrimenti non troveremmo mai corrispondeza
        $password = md5($password);
        if(mysql_num_rows(mysql_query("SELECT * FROM utenti WHERE email LIKE '$email' AND password='$password'")) > 0) {
    			$email = mysql_result(mysql_query("SELECT email FROM utenti WHERE email LIKE '$email'"), 0);

          if ($email == $admin_email) {
            $_SESSION['email'] = "ADMIN";
          } else{
            $_SESSION['email'] = $email;
          }

          header("location: index.php");
        }else {
           echo "LOGIN NON RIUSCITO";
           echo '<a href="javascript:history.back();">Indietro</a>';
          }
      }
    } elseif (isset($_POST['home'])) {
      header("location: index.php");
    }else {
      ?>
      <div class="box">
        <h2>Login</h2>
      	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      		<label><input type="email" class="label" name="email" placeholder="Email"  maxlength="60" /></label><br />
      		<label><input type="password" class="label" name="password" placeholder="Password"  maxlength="20" /></label><br />
      		<input type="submit" class="button" name="login" value="Accedi" />
          <input type="submit" class="button" name="home" value="Torna alla Home" />
    	  </form>
      </div>
    	<?php
    }
} else {
  header("location: index.php");
}
?>
