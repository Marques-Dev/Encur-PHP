"use strict"

function CreateURL(){
  //pegando o valor de txtUrl e passando para o js
  var txtUrl = document.getElementById("txtUrl").value;
  var pResult = document.getElementById("pResult");
  // limpar a tela depois q mostrar o erro
  pResult.innerHTML = "";

//regra para nao enviar nada vazio ou menor q 3 
  if(txtUrl.length <=3){
    pResult.innerHTML = "<span style='color: red;'>Invalid URL</span>";
    return false;
  }
}

function Delete(event){
  if(!confirm("Do you really want to remove this URL?"))
    return;
    event.disabled = true;
    event.value = "REMOVED";
    window.open("remove.php?id="+ event.getAttribute("data-id"), "_blank")
}


//função de login 
function Login(){
  var txtUserKey = document.getElementById("txtUserKey").value;
  var pResult = document.getElementById("pResult");
  pResult.innerHTML = "";
  //caso seja menor q 3 nao envia
  if(txtUserKey.length <= 3){
    pResult.innerHTML = "<span style='color: red;'>Invalid User key</span>";
    return false;
  }
  else{
    return true;
  }
}

function Copy(event){
  event.select();
  document.execCommand("copy");
}
