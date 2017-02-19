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
if (isset($_POST['rimuovi'])){
  $nome = isset($_POST['nome']) ? clear($_POST['nome']) : false;


  if(empty($nome)) {
		echo 'Riempi il campo nome.<br /><br /><a href="javascript:history.back();">Indietro</a>';
	} elseif (mysql_num_rows(mysql_query("SELECT * FROM prodotti WHERE nome LIKE '$nome'")) > 0) {
    $id = mysql_result(mysql_query("SELECT id FROM prodotti WHERE nome LIKE '$nome'"), 0);
    mysql_query("DELETE FROM prodotti WHERE id='$id'");
    header("Location: index.php");
  } else {
    echo 'Prodotto non trovato in catalogo.<br /><br /><a href="javascript:history.back();">Indietro</a>';
  }

}else {
  ?>
  <div class="login">
  <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
    <label><input type="text" class="login-label" name="nome" placeholder="Nome Prodotto" required maxlength="60" /></label><br />
    <input type="submit" class="login-button" name="rimuovi" value="Rimuovi" />
  </form>
  </div>
  <?php
}
?>
