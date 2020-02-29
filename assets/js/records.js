'use_strict';

/* Fetch list */
function RenderList() {
  function file_format(format) {
    if (format.match(/\b(\w*image\w*)\b/gi)) {
      return 'jpg.png';
    } else if (format.match(/\b(\w*presentation\w*)\b/gi)) {
      return 'ppt.png';
    } else if (format.match(/\b(\w*word\w*)\b/gi)) {
      return 'doc.png';
    } else if (format.match(/\b(\w*zip\w*)\b/gi)) {
      return 'zip.png';
    } else if (format.match(/\b(\w*text\w*)\b/gi)) {
      return 'txt.png';
    } else if (format.match(/\b(\w*spreadsheet\w*)\b/gi)) {
      return 'xls.png';
    } else if (format.match(/\b(\w*pdf\w*)\b/gi)) {
      return 'pdf.png';
    }
  }

  $.post('./assets/hndlr/Records.php', { fetchrecords: 'all' }, function(res) {
    $('.records-container').html('');

    if (res != 'err:fetch') {
      $.each(JSON.parse(res), function(idx, el) {
        if (!res.match(/\b(\w*err\w*)\b/g)) {
          $('.records-container').append(`
            <div class="col-md-3 col-lg-2 record-thumb">
               <div class="card">
                  <img class="card-img-top mx-auto mt-4" src="./assets/img/file_format/${file_format(
                    el.file_format
                  )}" data-id="${
            el.doc_id
          }" alt="format thumb" title="View description">
                  <div class="card-body pb-1">
                     <p class="font-weight-bold card-title mb-0" data-id="${
                       el.doc_id
                     }" title="View description">${el.title}</p>
                     <small class="text-muted">by ${AuthorName(el.author)} on ${
            el.uploaded_at
          }</small> <br>
                     <a href="./files/${el.doc_type}/${el.folder}/${
            el.attachment
          }" class="btn btn-link px-0 float-right download-links" data-target="${
            el.title
          }" title="Download file">
                        <i class="ni ni-cloud-download-95 ni-2x"></i>
                     </a>
                  </div>
               </div>
            </div>
         `);
        } else {
          if ($('body').hasClass('modal-open') === true) {
            $('.modal').on('shown.bs.modal', function() {
              let modalid = $(this).attr('id');
              if (modalid == 'SuccessModal') {
                $('#SuccessModal').on('hidden.bs.modal', function() {
                  ErrorModal('No uploaded files.', 0, 10000);
                });
              }
            });
          } else {
            ErrorModal('No uploaded files.', 0, 10000);
          }
          console.log('ERR', 'err:fetch');
        }
      });

      $('a.download-links').click(function(e) {
        e.preventDefault();
        var dir = $(this).prop('href'),
          file = $(this).attr('data-target');

        fileDownload(dir, file);
      });
    } else {
      console.log('ERR', 'err:fetch');
    }
  });
}
RenderList();

/* Triggers */
$(function() {
  /* Display file name */
  $('#select_file').on('change', function() {
    let file = $(this).val(),
      selectedfile = function() {
        let checker = $('#select_file')
          .val()
          .match(/[\/\\]([\w\d\s\'\.\,\-\(\)]+)$/);

        if (checker != null) {
          let selected_file = $('#select_file')
            .val()
            .match(/[\/\\]([\w\d\s\'\.\,\-\(\)]+)$/)[1];

          if (selected_file.length >= 12) {
            return (
              selected_file.substr(0, 11) +
              '...' +
              selected_file.substr(selected_file.length - 11)
            );
          } else {
            return selected_file;
          }
        } else {
          setTimeout(function() {
            $('label.select_file').html('Select a file...');
            $('#select_file')
              .addClass('is-invalid')
              .val('');
            $('small.select_file')
              .addClass('text-danger')
              .html('Invalid file: rename file');
            $('.custom-file').focusout();
          }, 500);
        }
      };

    ValidateAttachment('select_file'); // set format to form

    if (file) {
      $('label.select_file').html(selectedfile);
    } else {
      $('label.select_file').html('Select a file...');
    }
  });

  /* File type */
  $('#file_type').on('change', function() {
    let type = $(this).val();

    if (type == 'other') {
      $('#other_type')
        .removeClass('d-none')
        .focus();
      $(this).removeClass('is-invalid');
      $('small.file_type').html('');
    } else {
      $('#other_type').addClass('d-none');
    }
  });

  /* On modal open/close */
  $('#UploadModal').on('shown.bs.modal', function() {
    let author = AuthorId($('#whoiam').val());
    $('input#author').val(author);
  });

  /* Upload input validation/submit */
  $('#record_form').submit(function(e) {
    e.preventDefault();

    let form = $(this).serializeArray(),
      form_data = new FormData(),
      file = $('#select_file')[0].files[0];

    switch (false) {
      case ValidateTitle('record_form', 'title'):
      case ValidateType('file_type', 'other_type'):
      case ValidateAttachment('select_file'):
        break;

      default:
        form_data.append('select_file', file);
        $.each(form, function(key, input) {
          form_data.append(input.name, input.value);
        });

        $.ajax({
          type: 'POST',
          url: './assets/hndlr/Records.php',
          data: form_data,
          contentType: false,
          processData: false,
          success: function(res) {
            console.log(res);

            switch (res) {
              case 'true':
                SuccessModal('Document has been uploaded.', 0, 5000);
                RenderList();
                break;

              default:
                ErrorModal(0, 0, 5000);
                'show';
                console.log('ERR', res);
                break;
            }
          }
        });

        break;
    }
  });
});

/* FUNCTIONS */
function ValidateType(name1, name2) {
  let ctrl = true,
    name_attr1 = `[name="${name1}"]`,
    name_attr2 = `[name="${name2}"]`,
    input1 = $(name_attr1).val(),
    input2 = $(name_attr2).val(),
    regex = new RegExp(/^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/g),
    required1 = input1.length != 0 ? true : false,
    required2 = input2.length != 0 ? true : false;

  if (input1 == 'other') {
    switch (false) {
      case required2:
        $(name_attr2).addClass('is-invalid');
        $('small.' + name2)
          .removeClass('text-success')
          .addClass('text-danger')
          .html('Field required.');
        break;
      case regex.test(input2):
        $(name_attr2).addClass('is-invalid');
        $('small.' + name2)
          .removeClass('text-success')
          .addClass('text-danger')
          .html('Not a valid input.');
        break;

      default:
        $(name_attr2).removeClass('is-invalid');
        $('small.' + name2)
          .removeClass('text-success')
          .html('');
        break;
    }
  } else {
    switch (false) {
      case required1:
        $(name_attr1).addClass('is-invalid');
        $('small.' + name1)
          .removeClass('text-success')
          .addClass('text-danger')
          .html('Field required.');
        break;
      default:
        $(name_attr1).removeClass('is-invalid');
        $('small.' + name1)
          .removeClass('text-success')
          .html('');
        break;
    }
  }

  return ctrl;
}

function ValidateAttachment(name) {
  let ctrl = true,
    name_attr = $(`[name="${name}"]`);

  if (name_attr.val().length >= 1) {
    let file_format = name_attr[0].files[0].type;

    if (file_format.match(/\b(\w*text\w*)\b/gi)) {
      $('[name="format"]').val('text');
    } else if (file_format.match(/\b(\w*image\w*)\b/gi)) {
      $('[name="format"]').val('image');
    } else if (file_format.match(/\b(\w*pdf\w*)\b/gi)) {
      $('[name="format"]').val('pdf');
    } else if (file_format.match(/\b(\w*word\w*)\b/gi)) {
      $('[name="format"]').val('word');
    } else if (file_format.match(/\b(\w*presentationml\w*)\b/gi)) {
      $('[name="format"]').val('presentation');
    } else if (file_format.match(/\b(\w*spreadsheetml\w*)\b/gi)) {
      $('[name="format"]').val('spreadsheet');
    } else if (file_format.match(/\b(\w*zip\w*)\b/gi)) {
      $('[name="format"]').val('zip');
    } else {
      ctrl = false;
      console.log(file_format);
      $(name_attr).addClass('is-invalid');
      $('small.' + name)
        .removeClass('text-success')
        .addClass('text-danger')
        .html(
          'Invalid file format. (zip, image, text, pdf, word, presentation, spreadsheet)'
        );
    }
  } else {
    ctrl = false;
    $(name_attr).addClass('is-invalid');
    $('small.' + name)
      .removeClass('text-success')
      .addClass('text-danger')
      .html('Select a file.');
  }

  return ctrl;
}
