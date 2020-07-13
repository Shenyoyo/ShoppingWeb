$( document ).ready(function() {
  if($('#discount_yn').is(':checked')){
    
    $("#discount_yn").click(enable_discount);
  }else{
    enable_discount()
  }
  $("#discount_yn").click(enable_discount);
  
  if($('#cashback_yn').is(':checked')){
    $("#cashback_yn").click(enable_cashback);
  }else{
    enable_cashback()
  }
  $("#cashback_yn").click(enable_cashback);

  if($('#rebate_yn').is(':checked')){
    $("#rebate_yn").click(enable_rebate);
  }else{
    enable_rebate()
  }
  $("#rebate_yn").click(enable_rebate);
});
  
function enable_discount() {
  if (this.checked) {
    $("input.group1").removeAttr("disabled");
  } else {
    $("input.group1").attr("disabled", true);
  }
}
function enable_cashback() {
  if (this.checked) {
    $("input.group2").removeAttr("disabled");
  } else {
    $("input.group2").attr("disabled", true);
  }
}
function enable_rebate() {
  if (this.checked) {
    $("input.group3").removeAttr("disabled");
  } else {
    $("input.group3").attr("disabled", true);
  }
}