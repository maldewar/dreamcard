$(document).ready(function() {
  if (dc.getBootstrapEnv() != 'xs') {
    $('#amount').focus();
  }
  $("input[name='send_to']").change(function(e){
    if($(this).val() == '0') {
      $('#email_field').fadeOut('fast');
    } else {
      $('#email_field').fadeIn('fast').focus();
    }
  });
});
