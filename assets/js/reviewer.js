'use_strict';

/* Fetch list */
function RenderList() {
  $.post(
    './assets/hndlr/Reviewer.php',
    {
      fetchreviewers: 'all'
    },
    function(res) {
      $('.reviewers-container').html('');

      if (res != 'err:fetch') {
        $.each(JSON.parse(res), function(idx, el) {
          if (!res.match(/\b(\w*err\w*)\b/g)) {
            let regex = /^\s*$/,
              description = el.description,
              duration = '',
              level = '';

            if (!description.match(regex) === false) {
              description = '<i>No description...</i>';
            }

            switch (el.duration) {
              case '30':
                duration = '30 mins';
                break;
              case '45':
                duration = '45 mins';
                break;
              case '60':
                duration = '1 hour';
                break;
              case '90':
                duration = '1 hour and 30 mins';
                break;
              case '120':
                duration = '2 hours';
                break;
            }

            switch (el.level) {
              case 'gen':
                level = 'General';
                break;
              case 'prof':
                level = 'Professional';
                break;
              case 'eng':
                level = 'English';
                break;
              case 'fil':
                level = 'Filipino';
                break;
              case 'bio':
                level = 'Biology Sciences';
                break;
              case 'phys':
                level = 'Physical Sciences';
                break;
              case 'math':
                level = 'Mathematics';
                break;
              case 'socsci':
                level = 'Social Studies/Sciences';
                break;
              case 'values':
                level = 'Values';
                break;
              case 'mapeh':
                level = 'MAPEH';
                break;
              case 'agri':
                level = 'Agriculture and Fishery Arts';
                break;
              case 'tech':
                level = 'Technology and Livelihood';
                break;
            }

            $('.reviewers-container').append(`
            <div class="col-lg-10 reviewer-thumb">
               <div class="card pointer-here" title="Click for questionnaire..." data-id="${
                 el.rvwr_id
               }">
                  <div class="card-body pb-1">
                    <button type="button" class="btn btn-sm btn-secondary text-danger float-right delete_reviewer" data-target="${
                      el.rvwr_id
                    }" title="Delete reviewer...">
                        <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary text-purple float-right edit_reviewer" data-target="${
                      el.rvwr_id
                    }" title="Edit reviewer...">
                        <i class="fa fa-edit" aria-hidden="true"></i>
                    </button>
                     <p class="font-weight-bold mb-0 text-primary">${
                       el.title
                     }</p>
                     <p>
                        <small class="">${description}</small> <br>
                        <small class="text-capitalize">&bull;&ensp;Level: ${level} Education</small> <br>
                        <small class="">&bull;&ensp;Source: ${
                          el.source
                        }</small> <br>
                        <small class="">&bull;&ensp;No. of items: ${
                          el.items
                        }</small> <br>
                        <small class="">&bull;&ensp;Duraion: ${duration}</small>
                     </p>
                     <small class="text-muted">by ${AuthorName(el.author)} on ${
              el.created_at
            }</small>
                  </div>
               </div>
            </div>
          `);
          } else {
            console.log('err:res');
          }
        });
      } else {
        if ($('body').hasClass('modal-open') === true) {
          $('.modal').on('shown.bs.modal', function() {
            let modalid = $(this).attr('id');
            if (modalid == 'SuccessModal') {
              $('#SuccessModal').on('hidden.bs.modal', function() {
                ErrorModal('List is empty. Create a new reviewer.', 0, 10000);
              });
            }
          });
        } else {
          if ($('body').hasClass('modal-open') === true) {
            $('.modal').on('shown.bs.modal', function() {
              let modalid = $(this).attr('id');
              if (modalid == 'SuccessModal') {
                $('#SuccessModal').on('hidden.bs.modal', function() {
                  ErrorModal('List is empty. Create a new reviewer.', 0, 10000);
                });
              }
            });
          } else {
            ErrorModal('List is empty. Create a new reviewer.', 0, 10000);
          }
        }
        console.log('ERR', 'err:fetch');
      }
    }
  );
}

/* Triggers */
$(function() {
  RenderList();

  /* On modal open/close */
  $('#NewReviewer, #EditReviewer')
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
      $(
        formid + ' small.title, small.level, small.duration, small.source'
      ).html('');
      // $(formid + ' [name=""]').prop('selected', true);
    });

  /* New reviewer validation/submit */
  $('#reviewer_form').submit(function(e) {
    e.preventDefault();

    let form = $(this).serialize();

    switch (false) {
      case ValidateTitle('reviewer_form', 'title'):
      case ValidateRequired('reviewer_form', 'source'):
      case ValidateRequired('reviewer_form', 'level'):
      case ValidateRequired('reviewer_form', 'duration'):
        break;

      default:
        $.ajax({
          type: 'POST',
          url: './assets/hndlr/Reviewer.php',
          data: form,
          success: function(res) {
            switch (res) {
              case 'true':
                SuccessModal('Created new reviewer.', 0, 5000);
                RenderList();
                break;

              default:
                ErrorModal(0, 0, 5000);
                console.log('ERR', res);
                break;
            }
          }
        });

        break;
    }
  });

  /* Open reviewer */
  $('.reviewers-container').on('click', '.card.pointer-here', function(e) {
    let id = $(this).attr('data-id');

    sessionStorage.setItem('rvwr', id);
    window.location.href = 'questionnaire.php';
  });

  /* Fetch reviewer for modal */
  $('.reviewers-container').on('click', '.edit_reviewer', function(e) {
    e.stopPropagation();
    e.preventDefault();

    let reviewer = $(this).attr('data-target'),
      formid = 'form#edit_form ';

    $('#EditReviewer').modal('show');
    $.post(
      './assets/hndlr/Reviewer.php',
      {
        reviewer
      },
      function(res) {
        if (res != 'err:fetch') {
          $.each(JSON.parse(res), function(idx, el) {
            $(formid + '[name="reviewer_id"]').val(el.reviewer_id);
            $(formid + '[name="title"]').val(el.title);
            $(formid + '[name="source"]').val(el.source);
            $(formid + `[name="level"] option[value="${el.level}"]`).prop(
              'selected',
              true
            );
            $(formid + `[name="duration"] option[value="${el.duration}"]`).prop(
              'selected',
              true
            );
            $(formid + '[name="description"]').val(el.description);
          });
        } else {
          console.log('err:fetch');
        }
      }
    );
  });

  /* Update reviewer validation/submit */
  $('#edit_form').submit(function(e) {
    e.preventDefault();

    let form = $(this).serialize();

    switch (false) {
      case ValidateTitle('edit_form', 'title'):
      case ValidateRequired('edit_form', 'source'):
      case ValidateRequired('edit_form', 'level'):
      case ValidateRequired('edit_form', 'duration'):
        break;

      default:
        $.ajax({
          type: 'POST',
          url: './assets/hndlr/Reviewer.php',
          data: form,
          success: function(res) {
            switch (res) {
              case 'true':
                SuccessModal('Updated reviewer.', 0, 5000);
                RenderList();
                break;

              default:
                ErrorModal(0, 0, 5000);
                console.log('ERR', res);
                break;
            }
          }
        });

        break;
    }
  });

  /* Delete reviewer */
  $('.reviewers-container').on('click', '.delete_reviewer', function(e) {
    e.stopPropagation();
    e.preventDefault();

    let del = $(this).attr('data-target');
    PromptModal(
      'Are you deleting this reviewer?',
      0,
      10000,
      'delete_reviewer',
      del
    );
    PromptConfirm('Reviewer deleted.', './assets/hndlr/Reviewer.php');
  });
});
