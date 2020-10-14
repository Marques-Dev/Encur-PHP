<?php
//seguranca para nao ter transiçoes de telas indesejadas pela url 
session_start();
//se exister uma sessao me manda para o panel.php, em outras palavras caso esteja logado e relaizar um 
//refresh ainda vou continuar na minha tela panel.php.
if(isset($_SESSION["auth"])){
  header("Location: panel.php");
}

//verificar se o arquivo já foi incluído, caso ele tenha sido não será incluso novamente.
require_once("App/config.php");
$result = "";
//requisutando o arquivo de configuração config.php
$txtUserKey = filter_input(INPUT_POST, "txtUserKey", FILTER_SANITIZE_STRING);
//so entra na condição caso ele digite
if($txtUserKey){
  //caso a chave dele for igual a que esta no config ok, caso nao entra no else
  if($txtUserKey == USERKEY){
    //autneticação
    $_SESSION["auth"] = true;
    header("Location: panel.php");
  }else{
    $result = "chave errada";
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="utf-8">
  <title>Login - Encurtador Samu</title>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <link rel="shortcut icon" href="img/favicon.ico">
</head>
<body>
  <div class="max-width-login bg-white padding" style="margin-top:15%;">
    <h1>Encurtador - Samu</h1>
    <br>
    <form method="post" onsubmit="return Login();">
      <input class="input full-width" type="text" name="txtUserKey" id="txtUserKey" placeholder="Digite sua chave">
      <button type="submit" class="input btn-login full-width" name="button">Login</button>
    </form>
    <p id="pResult"><?=$result;?>&nbsp;</p>
  </div>
  <script src="js/script.js"></script>
</body>
</html>
