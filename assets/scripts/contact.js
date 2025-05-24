$(document).ready(function() {
    $("#contact_form").submit(function (event) {

        event.preventDefault();

        $("#contact_us_btn").text("SUBMITTING ...");
        $("#contact_us_btn").attr('disabled', true);
    
        $.ajax({
          url: 'submit-contact.php',
          method: 'post',
          dataType: 'json',
          data: {
            name: $("#contact_name").val(),
            email: $("#contact_email").val(),
            subject: $("#subject").val(),
            phone: $("#contact_phone").val(),
            message: $("#contact_message").val()
          },
          success: function (response) {
              $("#contact_us_btn").text("SUCCESS");
              $("#contact_us_btn").attr('disabled', false);

              setTimeout(function() {
                window.location.reload();
              }, 1000);
    
          }
        });
      });
});