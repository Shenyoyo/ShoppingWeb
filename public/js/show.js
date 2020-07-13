function subForm() {
  var nomessage = window.prompt("請輸入拒絕退款理由");
 
  if (nomessage != null) {
    if(nomessage == ""){
      alert('拒絕退款理由不得為空');
    }else{
      $('#nomessage').val(nomessage);
      $('#refund-disagree').submit();
    }
  }
 
}