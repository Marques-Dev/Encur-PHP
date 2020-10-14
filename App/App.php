<?php
require_once("Shortener.php");

class App{


  public function __construct(){
    //verifica de se existe um diretorio
    if(!is_dir(PATH)){
      //se nao existir ele cria 
      mkdir(PATH);
    }
  }

//verifica se esta chegando a url q foi digitada
  function Write(string $url){
    $shortener = new Shortener();
    $shortener->setId($this->GetUniqueId());
    $shortener->setUrl($url);
    $shortener->setAccess(0);

    $objData = serialize($shortener);


//conexao para o arquivo, e gravando o os dados em um arquivo
    $fp = fopen(PATH ."/".$shortener->getId(). ".db", "w");
    fwrite($fp, $objData);
    fclose($fp);

    return true;
  }

//fazendo com q tenha um unico id de url, assim eliminando a possibilidade de ter duas url com mesmo id 
  function GetUniqueId(){
    $allFiles= $this->ReadAll();
    $valid = false;
    $uniqueId = $this->GetRandomString(URLLENGTH);

    if($allFiles != null){ 
      // verificando se o id que foi sorteado pelo random nao e igual ao que esta nos arquivos, caso seja
      // ira sortear um novo usando o random ate q seja diferente

      //vai rodar ate q seja valido
      while(!$valid){
        $v = true;//s

        for ($i=0; $i < count($allFiles); $i++) {
          if(substr($allFiles[$i], 0, -3) == $uniqueId){ // -3 porque tem o '.db' no final dos arquivos, assim vai pegar somente o id 
            $v = false;
          }
        }

        if(!$v){ // se v for igual a falso gera um novo id para a url
          $uniqueId = $this->GetRandomString(URLLENGTH); // se foi sorteado um novo id para essa url, vai sobrepor
        }else{
          $valid = true;
        }
      }
    }

    return $uniqueId;
  }

  function ReadAll(){
    $files = $this->GetAllFiles();
    if(count($files)<=0)
    return;

    $listUrl = [];
    foreach($files as $f){
      $fullFile = PATH ."/".$f;
      if(file_exists($fullFile)){
        $objData = file_get_contents($fullFile);
        $listUrl[] = unserialize($objData);
      }
    }

    return $listUrl;
  }

//pegando os aquivos do diretorio 
  function GetAllFiles(){
    if(!is_dir(PATH))
    return;
    $var = scandir(PATH);
    $var = array_diff($var, array(".", ".."));
    return $var;
  }

  function GetUrlById(string $id){
    $f = PATH . "/{$id}.db";
    if(file_exists($f)){

      //READ FILE
      $objData = file_get_contents($f);
      $short = unserialize($objData);
      $short->setAccess($short->getAccess() + 1);

      //WRITEFILE
      $newObj = serialize($short);
      //enquenato uma pessoa mexe em um arquivo outra pessoa nao pode mexer nele, assim trazendo mais segurança
      $fp = fopen($f, "w");
      fwrite($fp, $newObj);
      fclose($fp);
      return $short->getUrl();
    }else{
      return "";
    }
  }

  function Debug($var){
    echo "<pre>";
    print_r($var);
    echo "</pre>";
  }
//-----------------------------------------------------------------------------------
//usando randomicamente caracters da variavel 'a'
  function GetRandomString(int $length){
    $a = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    //retorna 05
    $aLength = strlen($a);
    $str = "";

//percorrendo 
    for($i = 0; $i < $length; $i++){
      //str contatenado e adicionando em uma posição randon (rand)
      $str .= $a[rand(0, $aLength-1)];
      //-1 e para normalização de array
    }

    return $str;
  }
}

?>
