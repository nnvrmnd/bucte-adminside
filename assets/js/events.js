'use_strict';

/* Fetch list */
function RenderList() {
  $.post(
    './assets/hndlr/Events.php',
    {
      fetchevents: 'all'
    },
    function(res) {
      $('.events-container').html('');

      if (res != 'err:fetch') {
        $.each(JSON.parse(res), function(idx, el) {
          if (!res.match(/\b(\w*err:fetch\w*)\b/g)) {
            let regex = /^\s*$/,
              event_id = el.event_id,
              read_more = `<b>&hellip;</b>&ensp;<a href="javascript:void(0)" class="readmore" data-target="${event_id}">Read more</a>`,
              desc_raw = el.description,
              desc_replace = desc_raw.replace(
                /<\/?[br|li|ol|ul|p|strong|blockquotes]+\/?>/gim,
                ''
              ),
              desc_len = desc_replace.length,
              desc_substr = desc_replace.substr(0, 150),
              description =
                desc_len >= 150 ? desc_substr + read_more : desc_replace;

            $('.events-container').append(`
            <div class="card card-shadow" data-id="${event_id}">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                    <center>
                      <img alt="Image placeholder" src="./files/events/${
                        el.image
                      }" class="img-fluid rounded">
                    </center>
                  </div>
                  <div class="col-md-9">
                    <button type="button" class="btn btn-sm btn-secondary text-danger float-right delete_event"
                      title="Delete event..." data-target="${event_id}">
                      <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary text-purple float-right edit_event" title="Edit event..." data-target="${event_id}">
                      <i class="fa fa-edit" aria-hidden="true"></i>
                    </button>
                    <p class="font-weight-bold mb-0 text-primary">${
                      el.title
                    }</p>
                    <div class="mb-4">
                      <small class="text-capitalize">&bull;&ensp;Sechedule: ${
                        el.sched
                      }</small> <br>
                      <small class="">&bull;&ensp;Venue: ${
                        el.venue
                      }</small> <br>
                      <small class="">&bull;&ensp;Description: ${description}</small> <br>
                    </div>
                    <small class="text-muted">by ${AuthorName(el.author)} on ${
              el.created_at
            }</small>
                  </div>
                </div>
              </div>
            </div>
            `);

            /* $('.descdiv')
              .find('p')
              .css('font-size', '80%')
              .addClass('text-dark mb-0')

            $('.descdiv')
              .find('a')
              .css('font-size', '80%'); */
          } else {
          }
        });
      } else {
        if ($('body').hasClass('modal-open') === true) {
          $('.modal').on('shown.bs.modal', function() {
            let modalid = $(this).attr('id');
            if (modalid == 'SuccessModal') {
              $('#SuccessModal').on('hidden.bs.modal', function() {
                ErrorModal('List is empty. Create a new event.', 0, 10000);
              });
            }
          });
        } else {
          if ($('body').hasClass('modal-open') === true) {
            $('.modal').on('shown.bs.modal', function() {
              let modalid = $(this).attr('id');
              if (modalid == 'SuccessModal') {
                $('#SuccessModal').on('hidden.bs.modal', function() {
                  ErrorModal('List is empty. Create a new event.', 0, 10000);
                });
              }
            });
          } else {
            ErrorModal('List is empty. Create a new event.', 0, 10000);
          }
        }
      }
    }
  );
}

/* Triggers */
$(function() {
  RenderList();

  /* CKEditor */
  CKEDITOR.disableAutoInline = true;
  let ckwrites = $('body').find('.ckwrite');
  ckwrites.each(function(i, e) {
    CKEDITOR.replace(e.name, {
      customConfig: '/app/bucte/admin/assets/js/ck_events.js'
    });
  });

  /* On modal open/close */
  $('#NewEvent, #EditEvent')
    .on('shown.bs.modal', function() {
      let author = AuthorId($('#whoiam').val()),
        formid =
          'form#' +
          $(this)
            .find('form')
            .attr('id');
      $(formid + ' input[name="author"]').val(author);
    })
    .on('hidden.bs.modal', function() {
      let formid =
        'form#' +
        $(this)
          .find('form')
          .attr('id');
      $(formid + ' .form-control').removeClass('is-invalid is-valid');
      $(formid)
        .find('.cke_1')
        .removeAttr('style');
      $(
        'small.select_file, small.title, small.date, small.venue, small.description'
      ).html('');

      ClearCKE();
    });

  $('#dummy, [name="edit_dummy"]').click(function(e) {
    e.preventDefault();
    let file_input = $(this).attr('data-target');
    $(`[name="${file_input}"]`).click();
  });

  /* Display file name for new event */
  $('.file_select').on('change', function() {
    let regex = /[\/\\]([\w\d\s\'\.\,\-\(\)]+)$/,
      target_dummy = $(this).attr('data-target'),
      dummy = $(`[name="${target_dummy}"]`),
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
          dummy.val('').addClass('is-invalid');
          $('small.select_file')
            .addClass('text-danger')
            .html('Invalid filename. Rename file.');
          $(this).val('');
          break;

        default:
          dummy.val(slctd);
          dummy.removeClass('is-invalid');
          $('small.select_file').html('');
          break;
      }
    } else {
      // clear dummy if empty
      dummy.val('');
      dummy.removeClass('is-invalid');
      $('small.select_file').html('');
    }
  });

  /* Add new event */
  $('#event_form').submit(function(e) {
    e.preventDefault();

    InstanceCKE();

    let form = $(this).serializeArray(),
      form_data = new FormData(),
      file = $('#select_file')[0].files[0];

    switch (false) {
      case ValidateRequired('event_form', 'title'):
      case ValidateAttachment('event_form', 'select_file', 'dummy'):
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
                RenderList();
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

  /* Fetch event for modal */
  $('.events-container').on('click', '.edit_event', function(e) {
    e.stopPropagation();
    e.preventDefault();

    let event = $(this).attr('data-target'),
      image = filename => {
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
      };

    $('#EditEvent')
      .modal('show')
      .on('shown.bs.modal', function() {
        let formid = $(this)
          .find('form')
          .attr('id');

        $.post(
          './assets/hndlr/Events.php',
          {
            event
          },
          function(res) {
            if (res != 'err:fetch') {
              $.each(JSON.parse(res), function(idx, el) {
                $(`#${formid} [name="event_id"]`).val(el.event_id);
                $(`#${formid} [name="edit_title"]`).val(el.title);
                $(`#${formid} [name="edit_dummy"]`).val(image(el.image));
                $(`#${formid} [name="edit_date"]`).val(el.date);
                $(`#${formid} [name="edit_venue"]`).val(el.venue);
                InstanceCKE();
                CKEDITOR.instances[instance].setData(el.description);
              });
            } else {
              console.log('err:fetch', res);
            }
          }
        );
      });
  });

  /* Edit event */
  $('#editevent_form').submit(function(e) {
    e.preventDefault();

    InstanceCKE();

    let empty = /^\s*$/,
      form = $(this).serializeArray(),
      form_data = new FormData(),
      file = $('[name="edit_select_file"]')[0].files[0];

    switch (false) {
      case ValidateRequired('editevent_form', 'edit_title'):
      // case ValidateAttachment('editevent_form', 'edit_select_file', 'edit_dummy'):
      case ValidateDatetime('editevent_form', 'edit_date'):
      case ValidateRequired('editevent_form', 'edit_venue'):
      case ValidateCKE('editevent_form', 'edit_description'):
        break;

      default:
        form_data.append('edit_select_file', file);
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
                SuccessModal('Updated event.', 0, 5000);
                RenderList();
                break;

              default:
                ErrorModal(0, 0, 5000);
                break;
            }
          }
        });
        break;
    }
  });

  $('.events-container').on('click', '.delete_event', function(e) {
    e.stopPropagation();
    e.preventDefault();

    let del = $(this).attr('data-target');
    PromptModal('Are you deleting this event?', 0, 10000, 'delete_event', del);
    PromptConfirm('Event deleted.', './assets/hndlr/Events.php');
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
        .html('File not image.');
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
