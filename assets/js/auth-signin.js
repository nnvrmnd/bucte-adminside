'use strict';

$(function() {
  function errAuth() {
    $('#auth-alert').html('Incorrect credentials');
    $('[name="sudo_username"]').select();
    $('span.auth-icon')
      .removeClass('text-success')
      .addClass('text-danger');
  }

  setTimeout(() => {
    $('#sudo_username').focus();
  }, 1000);

  $('#sudo_auth').submit(function(e) {
    e.preventDefault();

    let auth_signin = $(this).serialize();

    $.ajax({
      type: 'POST',
      url: './assets/hndlr/AuthSignin.php',
      data: auth_signin,
      success: function(res) {
        switch (res) {
          case 'true':
            $('#auth-alert').html('');
            $('span.auth-icon')
              .removeClass('text-danger')
              .addClass('text-success');
            $(location).attr('href', 'dashboard.php');
            break;

          default:
            console.log(res);
            errAuth();
            break;
        }
      },
      error: function() {
        console.log('err: handling');
      }
    });
  });
});
