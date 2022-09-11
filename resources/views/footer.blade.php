<!-- Container-fluid Ends-->
        <!-- footer start-->
        <footer class="footer">
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-12 footer-copyright text-center">
                <p class="mb-0">Copyright 2022 © Yasir Bilal</p>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <!-- latest jquery-->
    <script src="../assets/js/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap js-->
    <script src="../assets/js/bootstrap/bootstrap.bundle.min.js"></script>
    <!-- feather icon js-->
    <script src="../assets/js/icons/feather-icon/feather.min.js"></script>
    <script src="../assets/js/icons/feather-icon/feather-icon.js"></script>
    <!-- scrollbar js-->
    <script src="../assets/js/scrollbar/simplebar.js"></script>
    <script src="../assets/js/scrollbar/custom.js"></script>
    <!-- Sidebar jquery-->
    <script src="../assets/js/config.js"></script>
    <!-- Plugins JS start-->
    <script src="../assets/js/sidebar-menu.js"></script>
    <script src="../assets/js/editor/ckeditor/ckeditor.js"></script>
    <script src="../assets/js/editor/ckeditor/adapters/jquery.js"></script>
    <script src="../assets/js/email-app.js"></script>
    <script src="../assets/js/tooltip-init.js"></script>
    <!-- Plugins JS Ends-->
    <!-- Theme js-->
    <script src="../assets/js/script.js"></script>
    <!-- login js-->
    <script>
         
    $("#inbox_click_event").click(function(){ 
      
      $("#pills-darkprofile").addClass("active");
      $("#pills-darkprofile").addClass("show");

      $("#pills-darkhome").removeClass("active");
      $("#pills-darkhome").removeClass("show");
      // var imgid = $('input[name=imgid]').val(); 

      $.ajaxSetup({
        headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      jQuery.ajax({
          url: "{{ url('/get_email_by_id') }}",
          method: 'post',
          data: {
              email_id: jQuery('#email_parent_id').val()
          },
          success: function(result){
            $("#sender_name").text(result.data.email_sender.name);
            $("#sender_time").text(result.data.created_at);
            $(".user-emailid").text(result.data.email_sender.email);
            $("#sender_subject").text(result.data.subject);
            $("#parent_email_content").text(result.data.email_sender.email+ " - " +result.data.content);

            
            jQuery.each(result.data.replies, function(index, value) {
              if(value.recipient.user_email == result.session.email) {
                $("#email_replies_div").append("<p id='my_replies'>" + value.recipient.user_email + " - " + value.content + "<p>");
              } else {
                $("#email_replies_div").append("<p id='email_replies'>" + value.recipient.user_email + " - " + value.content + "<p>");
              }
            });
          }
      });
    });
    $("#reply_all_id").click(function(){ 
      $.ajaxSetup({
        headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      jQuery.ajax({
          url: "{{ url('/reply_all') }}",
          method: 'post',
          data: {
              email_id: jQuery('#email_parent_id').val()
          },
          success: function(result){

            console.log(result);
          }
      });
    });
    </script>
    <!-- Plugin used-->
  </body>
</html>