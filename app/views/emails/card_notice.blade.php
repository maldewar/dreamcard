<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <h2>{{{ Lang::get('email.card_notice_title') }}}</h2>
    <p>
    {{{ Lang::get('email.card_notice_msg1',
          array('card_name'=>$card->name,
                'email' => $card_instance->to_user_email)) }}}
    </p>
    <p>
    {{{ Lang::get('email.card_sent_msg2_retail') }}}
    </p>
    <div>{{{ Lang::get('email.firm') }}}</div>
  </body>
</html>
