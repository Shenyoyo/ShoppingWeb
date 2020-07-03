$('.show_pass').click(function () {
  let pass_type = $('input.password').attr('type');

  if (pass_type === 'password' ){
      $('input.password').attr('type', 'text');
      $('.show_pass').removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
  } else {
      $('input.password').attr('type', 'password');
      $('.show_pass').removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
  }
})