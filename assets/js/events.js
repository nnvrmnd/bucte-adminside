'use_strict';

/* Fetch list */
function RenderList() {
  $.post(
    './assets/hndlr/Events.php', {
      fetchreviewers: 'all'
    },
    function (res) {
      $('.reviewers-container').html('');

      if (res != 'err:fetch') {
        $.each(JSON.parse(res), function (idx, el) {
          if (!res.match(/\b(\w*err\w*)\b/g)) {
            $('.reviewers-container').append(`
            <div class="col-lg-10 reviewer-thumb">
               <div class="card">
                  <div class="card-body pb-1">
                    <button type="button" class="btn btn-sm btn-secondary text-danger float-right delete_reviewer" data-target="${
                      el.rvwr_id
                    }" title="Delete reviewer">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                     <p class="font-weight-bold card-title mb-0 text-primary" title="Questionnaire" data-id="${
                       el.rvwr_id
                     }">${el.title}</p>
                     <p>
                        <small class="">${el.description}</small>
                     </p>
                     <small class="text-muted">by ${AuthorName(el.author)} on ${
              el.created_at
            }</small>
                  </div>
               </div>
            </div>
          `);
          } else {}
        });
      } else {}
    }
  );
}

/* Triggers */
$(function () {
  /* CKEditor */
  CKEDITOR.disableAutoInline = true;
  CKEDITOR.replace('description', {
    customConfig: '/bucte/admin/assets/js/ck_events.js'
  });

  /* On modal open/close */
  $('#NewEvent, #EditEvent')
    .on('shown.bs.modal', function () {
      let author = AuthorId($('#whoiam').val()),
        formid =
        'form#' +
        $(this)
        .find('form')
        .attr('id');
      $(formid + ' input[name="author"]').val(author);
    })
    .on('hidden.bs.modal', function () {
      let formid =
        'form#' +
        $(this)
        .find('form')
        .attr('id');
      $(formid + ' .form-control').removeClass('is-invalid is-valid');
      $(formid + ' small').html('');

      ClearCKE();
    });

  $('#dummy').click(function (e) {
    e.preventDefault();
    $('#select_file').click();
  });

  /* Display file name */
  $('#select_file').on('change', function () {
    let regex = /[\/\\]([\w\d\s\'\.\,\-\(\)]+)$/,
      dummy = $('#dummy'),
      fakepath = $(this).val(),
      filename,
      selected = () => {
        if (fakepath.match(regex) != null) {
          filename = fakepath.match(regex)[1];

          if (filename.length >= 12) {
            // if file name is long
            return (
              filename.substr(0, 11) +
              '...' +
              filename.substr(filename.length - 11)
            );
          } else {
            return filename;
          }
        } else {
          return 'invalid';
        }
      };

    if (fakepath) {
      let slctd = selected();
      switch (slctd) {
        case 'invalid':
          dummy
            .val('')
            .addClass('is-invalid');
          $('small.select_file')
            .addClass('text-danger')
            .html('Invalid filename. Rename file.');
          $(this).val('');
          break;

        default:
          $('#dummy').val(slctd)
          dummy.removeClass('is-invalid');
          $('small.select_file').html('');
          break;
      }

    } else {
      // clear dummy if empty
      $('#dummy').val('');
      dummy.removeClass('is-invalid');
      $('small.select_file').html('');
    }
  });

  $('#event_form').submit(function (e) {
    e.preventDefault();

    InstanceCKE();

    let form = $(this).serializeArray(),
      form_data = new FormData(),
      file = $('#select_file')[0].files[0];

    switch (false) {
      case ValidateAttachment('event_form', 'select_file', 'dummy'):
      case ValidateRequired('event_form', 'title'):
      case ValidateDatetime('event_form', 'date'):
      case ValidateRequired('event_form', 'venue'):
      case ValidateCKE('event_form', 'description'):
        break;

      default:
        form_data.append('select_file', file);
        $.each(form, function(key, input) {
          form_data.append(input.name, input.value);
        });

        $.ajax({
          type: 'POST',
          url: './assets/hndlr/Events.php',
          data: form_data,
          contentType: false,
          processData: false,
          success: function(res) {

            switch (res) {
              case 'true':
                SuccessModal('Added new event.', 0, 5000);
                // RenderList();
                break;

              default:
                ErrorModal(0, 0, 5000);
                'show';
                break;
            }
          }
        });
        break;
    }


  });

});

function InstanceCKE() {
  for (instance in CKEDITOR.instances) {
    CKEDITOR.instances[instance].updateElement();
  }
}

function ClearCKE() {
  InstanceCKE();
  CKEDITOR.instances[instance].setData('');
}

function ValidateAttachment(form_id, name, dummy_name) {
  let ctrl = true,
    formid = `form#${form_id} `,
    name_attr = formid + `[name="${name}"]`,
    dummy = formid + `[name="${dummy_name}"]`;

  if ($(name_attr).val().length >= 1) {
    let file_format = $(name_attr)[0].files[0].type;

    if (!file_format.match(/\b(\w*image\w*)\b/gi)) {
      ctrl = false;
      console.log(file_format);
      $(dummy).addClass('is-invalid');
      $('small.' + name)
        .removeClass('text-success')
        .addClass('text-danger')
        .html(
          'File not image.'
        );
    }
  } else {
    ctrl = false;
    $(dummy).addClass('is-invalid');
    $('small.' + name)
      .removeClass('text-success')
      .addClass('text-danger')
      .html('Select a file.');
  }

  return ctrl;
}