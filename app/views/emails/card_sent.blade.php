<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta charset="utf-8">
  </head>
  <body>
    <h2>{{{ Lang::get('email.card_sent_title') }}}</h2>
    <p>
    {{{ Lang::get('email.card_sent_msg1_retail',
          array('retail'=>$card->name,
                'email' => $recipient_user_email,
                'amount' => $amount,
                'currency' => ($sender->location==1?Lang::get('site.mexican_pesos'):Lang::get('site.us_dollars')))) }}}
    </p>
    <p>
    {{{ Lang::get('email.card_sent_msg2_retail') }}}
    </p>
    <div>{{{ Lang::get('email.firm') }}}</div>
  </body>
</html>
