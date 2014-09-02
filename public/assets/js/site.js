dc = {
  val: {
    envs: ['xs', 'sm', 'md', 'lg']
  },
  getBootstrapEnv: function() {
    $el = $('<div>');
    $el.appendTo($('body'));

    for (var i = this.val.envs.length - 1; i >= 0; i--) {
        var env = this.val.envs[i];

        $el.addClass('hidden-'+env);
        if ($el.is(':hidden')) {
            $el.remove();
            return env
        }
    }
  }
};
$(document).ready(function(){
  $('.one-click').click(function(){
    $(this).attr('disabled', true).closest('form').submit();
  });
});
