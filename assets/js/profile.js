

$(function() {
  let whoiam = $('#whoiam').val(); // User logged in

  /* Fetch user's profile infos */
  function FetchInfo(whoiam) {
    $.post('./assets/hndlr/Profile.php', { who: whoiam }, function(res) {
      $.each(JSON.parse(res), function(idx, el) {
        if (!res.match(/\b(\w*err\w*)\b/g)) {
          $('[name="user_profile"]').val(el.id);
          $('[name="user_profile2"]').val(el.id);
          $('[name="given"]').val(el.given);
          $('[name="surname"]').val(el.surname);
          $('[name="email"]').val(el.email);
          $('[name="username"]').val(el.username);
					$('#position').html(el.position);

					$('#name').html(el.given + '&nbsp;' + el.surname);
        } else {
          console.log('err: ');
        }
      });
    });
  }
  FetchInfo(whoiam);

  /* Change buttons' states */
  $('#edit-btn')
    .css('cursor', 'pointer')
    .click(function(e) {
      e.preventDefault();

      $('.profileform').removeAttr('readonly');
      $(this).addClass('d-none');
      $('#form-btns').removeClass('d-none');
      $('[name="username"]').select();
    });

  $('#cancel-btn').click(function(e) {
    e.preventDefault();

    FetchInfo(whoiam);

    $('.profileform').attr('readonly', '');
    $('#submit-btn').attr('disabled', '');
    $('#edit-btn').removeClass('d-none');
    $('#form-btns').addClass('d-none');
    $('#edit-btn').focus();
  });

  $('.form-control-alternative').keydown(function(e) {
    $('#submit-btn').removeAttr('disabled');
  });

  $('#submit-btn').click(function(e) {
    e.preventDefault();

    switch (false) {
      case ValidateUsername('username'):
      case ValidateEmail('email'):
      case ValidateName('given'):
      case ValidateName('surname'):
        break;
      default:
        $('#profile_form').submit();
        break;
    }
  });

  $('#profile_form').submit(function(e) {
    e.preventDefault();

		WaitModal('Processing...', 0, 5000);

    let profile_form = $(this).serialize();

    $.ajax({
      type: 'POST',
      url: './assets/hndlr/Profile.php',
      data: profile_form,
      success: function(res) {
        switch (res) {
          case 'true':
            $('#cancel-btn').click();
            SuccessModal(
              'Your profile info has been updated.<br>[You might need to re-login]',
              'authenticate.php',
              5000
            );
            setTimeout(() => {
              WhoAmI('topnav');
              FetchInfo(whoiam);
            }, 1000);
            break;

          default:
            ErrorModal(0, 0, 5000);('show');
            console.error('ERR', res);
            break;
        }
      }
    });
  });
});

$(function() {
  $('input.changepassword').keydown(function(e) {
    $('label.changepassword').removeClass('text-danger');
    $('small.changepassword')
      .removeClass('text-danger')
      .html('');
  });

  $('#newpassword_form').submit(function(e) {
		e.preventDefault();

		WaitModal('Processing...', 0, 5000);

    let newpassword_form = $(this).serialize();
    var neww = $('#new').val(),
      confirmed = $('#confirmed').val(),
      regex = new RegExp(neww);

    if (neww.length <= 4) {
      $('label.new').addClass('text-danger');
      $('label.confirmed').addClass('text-danger');
      $('small.confirmed')
        .removeClass('text-success')
        .addClass('text-danger')
        .html('Enter a combination of at least 5 characters.');
    } else if (confirmed !== neww) {
      $('label.new').addClass('text-danger');
      $('label.confirmed').addClass('text-danger');
      $('small.confirmed')
        .removeClass('text-success')
        .addClass('text-danger')
        .html("Passwords don't match.");
    } else {
      $.ajax({
        type: 'POST',
        url: './assets/hndlr/Profile.php',
        data: newpassword_form,
        success: function(res) {
          if (res.match(/\b(incorrect)\b/g)) {
            $('label.current').addClass('text-danger');
            $('small.current')
              .removeClass('text-success')
              .addClass('text-danger')
              .html('Incorrect password.');
          } else {
            if (res.match(/\b(update)\b/g)) {
              ErrorModal(0, 0, 5000);('show');
              console.log(res);
            } else if (res == 'true') {
              $('#ChangePassword-Modal').modal('hide');
              SuccessModal(
                'Your profile info has been updated.<br>[You might need to re-login]',
                'authenticate.php',
                5000
              );
              $('#SuccessModal').on('hidden.bs.modal', function() {
                $('#sudo_exit').click();
              });
            } else {
              ErrorModal(0, 0, 5000);('show');

            }
          }
        }
      });
    }
  });
});
