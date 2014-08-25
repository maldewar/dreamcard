$(document).ready(function() {
  $('.dc-card','.dc-cards').each(function(){
    $(this).click(function(){
      $('.dc-card').removeClass('selected');
      $(this).addClass('selected');
      var url = $(this).data('url');
      location.href=url;
    });
  });
});
