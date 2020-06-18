$(function() {
    $("#discount_yn").click(enable_discount);
    $("#cashback_yn").click(enable_cashback);
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