<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <h2>{{{ Lang::get('email.card_received_title') }}}</h2>
    <p>
    @if ($card->id == 0)
    {{{ Lang::get('email.yupicard_received_msg1',
          array('retail'=>$card->name,
                'amount' => $amount,
                'sendername' => $sendername,
                'currency' => ($sender->location==1?Lang::get('site.mexican_pesos'):Lang::get('site.us_dollars')))) }}}
    @else
    {{{ Lang::get('email.card_received_msg1_retail',
          array('retail'=>$card->name,
                'amount' => $amount,
                'sendername' => $sendername,
                'currency' => ($sender->location==1?Lang::get('site.mexican_pesos'):Lang::get('site.us_dollars')))) }}}
    @endif
    </p>
    <div style="text-align:center">
      <a href="{{{ $card_instance->url(true) }}}">{{{ Lang::get('email.card_instance_link', array('retail' => $card->name)) }}}</a>
    </div>
    <div>{{{ Lang::get('email.firm') }}}</div>
  </body>
</html>
