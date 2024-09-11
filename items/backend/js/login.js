$(document).ready(function () {
  disableResetPwButtonAfterSubmit();
  forgetPw();
});

function forgetPw() {
  $("#forget_pw").click(function () {
    $('#resetpw_overlay').show();
  });

  $("#close_reset").click(function () {
    $("#resetpw_overlay").hide();
  });
}

function disableResetPwButtonAfterSubmit() {
  $('#reset_form').on('submit', function () {
    $('#send_reset').prop('disabled', true);
  });
}
