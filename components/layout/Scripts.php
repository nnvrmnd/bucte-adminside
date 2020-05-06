<!-- ERROR MODAL -->
<div class="modal fade" id="ErrorModal" tabindex="-1" role="dialog" aria-labelledby="ErrorModal" data-backdrop="static"
   aria-hidden="true">
   <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
      <div class="modal-content bg-gradient-danger">
         <div class="modal-header">
            <h6 class="modal-title" id="modal-title-notification">
               <!-- Your attention is required -->
            </h6>
            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button> -->
         </div>
         <div class="modal-body">
            <div class="py-3 text-center">
               <i class="ni ni-fat-remove ni-5x"></i>
               <h4 class="heading mt-4">OOPS!</h4>
               <p class="font-weight-normal" id="error-modal-msg"></p>
            </div>
         </div>
         <div class="modal-footer">
            <!-- <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</button> -->
            <button type="button" class="btn btn-white" data-dismiss="modal">Ok, Got it</button>
         </div>
      </div>
   </div>
</div>

<!-- SUCCESS MODAL -->
<div class="modal fade" id="SuccessModal" tabindex="-1" role="dialog" aria-labelledby="SuccessModal"
   data-backdrop="true" aria-hidden="true">
   <div class="modal-dialog modal-success modal-dialog-centered modal-" role="document">
      <div class="modal-content bg-gradient-success">
         <div class="modal-header">
            <h6 class="modal-title" id="modal-title-notification">
               <!-- Your attention is required -->
            </h6>
            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button> -->
         </div>
         <div class="modal-body">
            <div class="py-3 text-center">
               <i class="ni ni-check-bold ni-5x"></i>
               <h4 class="heading mt-4">GREAT!</h4>
               <p class="font-weight-normal" id="success-modal-msg"></p>
            </div>
         </div>
         <div class="modal-footer">
            <!-- <button type="button" class="btn btn-link text-white ml-auto" data-dismiss="modal">Close</button> -->
            <button type="button" class="btn btn-white" data-dismiss="modal">Ok, Got it</button>
         </div>
      </div>
   </div>
</div>

<!-- PROMPT MODAL -->
<div class="modal fade" id="PromptModal" tabindex="-1" role="dialog" aria-labelledby="PromptModal"
   data-backdrop="static" aria-hidden="true">
   <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
      <div class="modal-content bg-gradient-danger">
         <div class="modal-header">
            <h6 class="modal-title" id="modal-title-notification">
               <!-- Your attention is required -->
            </h6>
            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button> -->
         </div>
         <div class="modal-body">
            <div class="py-3 text-center">
               <i class="ni ni-notification-70 ni-3x"></i>
               <h4 class="heading mt-4">HEY!</h4>
               <p class="font-weight-normal" id="prompt-modal-msg"></p>
            </div>
         </div>
         <div class="modal-footer">
            <form role="form" id="prompt_form">
               <button type="button" class="btn btn-secondary ml-auto" data-dismiss="modal">Cancel</button>
               <button type="submit" class="btn btn-warning text-white" id="yes_prompt">Yes</button>
            </form>
         </div>
      </div>
   </div>
</div>

<!-- Argon Scripts -->
<!-- Core -->
<script src="./dist/vendor/jquery/dist/jquery.min.js"></script>
<script src="./dist/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="./dist/vendor/js-cookie/js.cookie.js"></script>
<script src="./dist/vendor/jquery.scrollbar/jquery.scrollbar.min.js"></script>
<script src="./dist/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js"></script>
<!-- Optional JS -->
<script src="./dist/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="./dist/vendor/moment.min.js"></script>
<script src="./dist/vendor/bootstrap-datetimepicker.js"></script>
<script src="./dist/vendor/chart.js/dist/Chart.min.js"></script>
<script src="./dist/vendor/chart.js/dist/Chart.extension.js"></script>
<script src="./dist/vendor/jvectormap-next/jquery-jvectormap.min.js"></script>
<script src="./dist/js/vendor/jvectormap/jquery-jvectormap-world-mill.js"></script>
<!-- Argon JS -->
<script src="./dist/js/argon.min5438.js?v=1.2.0"></script>
<!-- Demo JS - remove this in your project -->
<script src="./dist/js/demo.min.js"></script>
<!-- Neil Francis Bayna -->
<script src="./assets/js/functions.js"></script>
<script src="./assets/js/global.js"></script>