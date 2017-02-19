<?php
include('connessione_db.php');
echo "<style>
.login {
  padding: 40px;
  width: 274px;
  background-color: #F7F7F7;
  margin: 0 auto 10px;
  border-radius: 2px;
  box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
  }
.login-button {
    width: 100%;
    display: block;
    margin-bottom: 10px;
    position: relative;
  }
.login-label {
    height: 44px;
    font-size: 16px;
    width: 100%;
    margin-bottom: 10px;
    -webkit-appearance: none;
    background: #fff;
    border: 1px solid #d9d9d9;
    border-top: 1px solid #c0c0c0;
    /* border-radius: 2px; */
    padding: 0 8px;
    box-sizing: border-box;
    -moz-box-sizing: border-box;
  }

  </style>";
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
			$userid = mysql_result(mysql_query("SELECT id FROM utenti WHERE email LIKE '$email'"), 0);


      if ($email == "admin@admin.it") {
        $_SESSION['email'] = "ADMIN";
      } else{
        $_SESSION['email'] = $email;
      }
			$_SESSION['userid'] = $userid;
      
      echo "LOGIN";
      header("location: index.php");
    }else {
       echo "LOGIN NON RIUSCITO";
       echo '<a href="javascript:history.back();">Indietro</a>';
      }
  }
} else {
  ?>
  <div class="login">
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
		<label><input type="email" class="login-label" name="email" placeholder="Email" required maxlength="60" /></label><br />
		<label><input type="password" class="login-label" name="password" placeholder="Password" required maxlength="20" /></label><br />
		<input type="submit" class="login-button" name="login" value="Accedi" />
	</form>
  </div>
	<?php
}
?>
