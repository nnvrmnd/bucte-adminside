function ValidateUsername(name) {
  var ctrl = true,
    validation = true,
    who = $('#whoiam').val(),
    name_attr = '[name="' + name + '"]',
    input = $(name_attr).val(),
    regex = new RegExp(/^[a-z0-9_]{5,16}$/gi),
    length = input.length >= 5 ? true : false,
    required = input.length != 0 ? true : false;

  $.ajax({
    type: 'POST',
    url: './assets/hndlr/Profile.php',
    data: { validatewho: input, profile: who },
    async: false,
    success: function(res) {
      switch (res) {
        case 'not available':
          validation = false;
          break;
        case 'available':
          break;
        default:
          validation = false;
          console.log('ValidateUsername', res);
          break;
      }
    }
  });

  switch (false) {
    case required:
      $('label.' + name).addClass('text-danger');
      $('small.' + name)
        .removeClass('text-success')
        .addClass('text-danger')
        .html('Field required.');
      ctrl = false;
      break;
    case length:
      $('label.' + name).addClass('text-danger');
      $('small.' + name)
        .removeClass('text-success')
        .addClass('text-danger')
        .html('Use 5 characters or more for your username.');
      ctrl = false;
      break;
    case regex.test(input):
      $('label.' + name).addClass('text-danger');
      $('small.' + name)
        .removeClass('text-success')
        .addClass('text-danger')
        .html('You can use letters, numbers & underscores.');
      ctrl = false;
      break;
    case validation:
      $('label.' + name).addClass('text-danger');
      $('small.' + name)
        .removeClass('text-success')
        .addClass('text-danger')
        .html('Username not available');
      ctrl = false;
      break;

    default:
      $('label.' + name).removeClass('text-danger');
      $('small.' + name)
        .removeClass('text-danger')
        .addClass('text-success')
        .html('Available');
      setTimeout(() => {
        $('small.' + name)
          .removeClass('text-success')
          .html('');
      }, 3000);
      break;
  }

  return ctrl;
}

function ValidateEmail(name) {
  var ctrl = true,
    validation = true,
    who = $('#whoiam').val(),
    name_attr = '[name="' + name + '"]',
    input = $(name_attr).val(),
    regex = new RegExp(
      /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/gi
    ),
    length = input.length >= 5 ? true : false,
    required = input.length != 0 ? true : false;

  $.ajax({
    type: 'POST',
    url: './assets/hndlr/Profile.php',
    data: { validateemail: input, profile: who },
    async: false,
    success: function(res) {
      switch (res) {
        case 'not available':
          validation = false;
          break;
        case 'available':
          break;
        default:
          validation = false;
          console.log('ValidateEmail', res);
          break;
      }
    }
  });

  switch (false) {
    case required:
      $('label.' + name).addClass('text-danger');
      $('small.' + name)
        .removeClass('text-success')
        .addClass('text-danger')
        .html('Field required.');
      ctrl = false;
      break;
    case regex.test(input):
      $('label.' + name).addClass('text-danger');
      $('small.' + name)
        .removeClass('text-success')
        .addClass('text-danger')
        .html('Not a valid email address.');
      ctrl = false;
      break;
    case validation:
      $('label.' + name).addClass('text-danger');
      $('small.' + name)
        .removeClass('text-success')
        .addClass('text-danger')
        .html('Email already registered');
      ctrl = false;
      break;

    default:
      $('label.' + name).removeClass('text-danger');
      $('small.' + name)
        .removeClass('text-danger')
        .addClass('text-success')
        .html('Available');
      setTimeout(() => {
        $('small.' + name)
          .removeClass('text-success')
          .html('');
      }, 3000);
      break;
  }

  return ctrl;
}

function ValidateName(name) {
  var ctrl = true,
    name_attr = '[name="' + name + '"]',
    input = $(name_attr).val(),
    regex = new RegExp(/^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/g),
    required = input.length != 0 ? true : false;

  switch (false) {
    case required:
      $('label.' + name).addClass('text-danger');
      $('small.' + name)
        .removeClass('text-success')
        .addClass('text-danger')
        .html('Field required.');
      break;
    case regex.test(input):
      $('label.' + name).addClass('text-danger');
      $('small.' + name)
        .removeClass('text-success')
        .addClass('text-danger')
        .html('Not a valid name.');
      break;

    default:
      $('label.' + name).removeClass('text-danger');
      $('small.' + name)
        .removeClass('text-success')
        .html('');
      break;
  }

  return ctrl;
}
