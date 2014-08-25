<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <h2>{{{ Lang::get('email.card_sent_self_title') }}}</h2>
    <p>
    {{{ Lang::get('email.card_sent_self_msg1_retail',
          array('retail'=>$card->name,
                'amount' => $amount,
                'currency' => ($user->location==1?Lang::get('site.mexican_pesos'):Lang::get('site.us_dollars')))) }}}
    </p>
    <div style="text-align:center">
      <a href="{{{ $card_instance->url(true) }}}">{{{ Lang::get('email.card_instance_link', array('retail' => $card->name)) }}}</a>
    </div>
    <p>
    {{{ Lang::get('email.card_sent_msg2_retail') }}}
    </p>
    <div>{{{ Lang::get('email.firm') }}}</div>
  </body>
</html>
