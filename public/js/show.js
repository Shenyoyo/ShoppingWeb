function subForm() {
  var nomessage = prompt("請輸入拒絕退款理由");
  if (nomessage != null) {
    $('#btn-refund-disagree').val(nomessage);
    $('#refund-disagree').submit();
  }
}