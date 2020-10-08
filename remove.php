<?php
require_once("App/config.php");
$id = filter_input(INPUT_GET, "id", FILTER_SANITIZE_STRING);

if($id){
  //unlink(PATH ."/". $id.".db");
  $f = PATH."/{$id}.db";
  //verificando se o arquivo realmente existe
  if(file_exists($f)){
    unlink($f);
    echo "<script>window.close();</script>";
  }
}
?>
