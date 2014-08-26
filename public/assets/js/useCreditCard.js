$(document).ready(function() {
  if (dc.getBootstrapEnv() != 'xs') {
    $('#amount').focus();
  }
  $("input[name='send_to']").change(function(e){
    if($(this).val() == '0') {
      $('.selectize-control').fadeOut('fast');
    } else {
      $('.selectize-control').fadeIn('fast').focus();
    }
  });
  $('#email_field').focus(function(){
    $("input[name='send_to'][value='1']").attr('checked', true);
  });
  var REGEX_EMAIL = '([a-z0-9!#$%&\'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+/=?^_`{|}~-]+)*@' +
                    '(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?)';

  $('#email_field').selectize({
      persist: false,
      maxItems: 1,
      createOnBlur: true,
      valueField: 'email',
      labelField: 'name',
      searchField: ['name', 'email'],
      options: contacts,
      render: {
          item: function(item, escape) {
              return '<div>' +
                  (item.name ? '<span class="name">' + escape(item.name) + '</span>' : '') +
                  (item.email ? '<span class="email">' + escape(item.email) + '</span>' : '') +
              '</div>';
          },
          option: function(item, escape) {
              var label = item.name || item.email;
              var caption = item.name ? item.email : null;
              return '<div>' +
                  '<span>' + escape(label) + '</span>' +
                  (caption ? '<span class="caption">' + escape(caption) + '</span>' : '') +
              '</div>';
          }
      },
      createFilter: function(input) {
          var match, regex;

          // email@address.com
          regex = new RegExp('^' + REGEX_EMAIL + '$', 'i');
          match = input.match(regex);
          if (match) return !this.options.hasOwnProperty(match[0]);

          // name <email@address.com>
          regex = new RegExp('^([^<]*)\<' + REGEX_EMAIL + '\>$', 'i');
          match = input.match(regex);
          if (match) return !this.options.hasOwnProperty(match[2]);

          return false;
      },
      create: function(input) {
          if ((new RegExp('^' + REGEX_EMAIL + '$', 'i')).test(input)) {
              return {email: input};
          }
          return true;
          var match = input.match(new RegExp('^([^<]*)\<' + REGEX_EMAIL + '\>$', 'i'));
          if (match) {
              return {
                  email : match[2],
                  name  : $.trim(match[1])
              };
          }
          return false;
      }
  });
});


