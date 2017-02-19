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
if (isset($_POST['registrati'])) {
	$email = isset($_POST['email']) ? clear($_POST['email']) : false;
  $password = isset($_POST['password']) ? clear($_POST['password']) : false;

  //Effettuo una serie di controlli sui dati immessi nel form per la Registrazione
  //Da come ho impostato la tabella utenti del db è necessario rispettare alcuni vincoli:
  //il campo email può contenere 60 caratteri al massimo, il campo della password ne può contenere al massimo 32 caratteri (dato che vorrei implementare la cifratura md5)
  //il campo della password ne può contenere al massimo 32 caratteri (dato che vorrei implementare la cifratura md5), tuttavia una lunghezza massima di 20 caratteri dovrebbe essere consona
  //il campo della password dovrebbe anche contenere un numero minimo di carattare per far si che la password possa ritenersi sufficientemente sicura ( io ho scelto 6)
  //E' necessario anche controllare che l'indirizzo email immesso non sia già presente all'interno del db

  if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		echo 'Indirizzo email non valido.';
	} elseif(strlen($email) > 60) {
		echo 'Lunghezza dell\'indirizzo email non valida. Massimo 60 caratteri.<br /><br /><a href="javascript:history.back();">Indietro</a>';
  } elseif(strlen($password) < 6 || strlen($password) > 20) {
		echo 'Lunghezza della password non valida. Minimo 6 caratteri e massimo 20.<br /><br /><a href="javascript:history.back();">Indietro</a>';
  } elseif(mysql_num_rows(mysql_query("SELECT * FROM utenti WHERE email LIKE '$email'")) > 0) {
      //se questa query restituisce un numero di righe maggiore di 0 significa che l'indirizzo email inserito è gia stato registrato
      //utilizzo "WHERE email LIKE '$email'" anzicchè "WHERE email='$email'" perchè voglio assicurarmi che la ricerca non sia CASE SENSITIVE
      //ciao@ciao.it per me è uguale a CiAo@ciao.it
  		echo 'Indirizzo email già in uso. <br /><br /><a href="javascript:history.back();">Indietro</a>';
  }else {
      //Tutti i controlli sono stati superati qui, posso procedere all'inserimento dei dati nel db
      //La prima cosa da fare è criptare la password
      $password = md5($password);
      if (mysql_query("INSERT INTO utenti (email, password) VALUES ('$email','$password')")) {
        header("location: index.php");
      } else {
        echo 'Errone nella query' .mysql_error();
      }
    }
} else {
    ?>
		<div class="login">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
      <label><input type="email" class="login-label" name="email" placeholder="Email" required maxlength="60" /></label><br />
      <label><input type="password" class="login-label" name="password" placeholder="Password" required maxlength="20" /></label><br /><br />
      <input type="submit" class="login-button" name="registrati" value="Registrati" />
    </form>
	</div>
    <?php
}
?>
