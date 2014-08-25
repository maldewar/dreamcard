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
  $('#email_field').focus(function(){
    $("input[name='send_to'][value='1']").attr('checked', true);
  });
});
