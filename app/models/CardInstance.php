<?php

class CardInstance extends Eloquent {
  const STATUS_NOT_CLAIMED = 0;
  const STATUS_CLAIMED = 1;

  const CURRENCY_MXN = 0;
  const CURRENCY_USD = 1;

	protected $guarded = array();

	public static $rules = array(
		'from_user_id' => 'required',
		'amount' => 'required',
		'currency' => 'required',
		'to_user_id' => 'required',
		'to_user_email' => 'required',
		'card_id' => 'required',
		'status' => 'required'
  );

  public function url($absolute) {
    return CardInstance::getUrl($this->code, $absolute);
  }

  public static function getUrl($code, $absolute) {
    $url = '/myCards/' . $code . '/claim';
    if ($absolute)
      $url = 'http://' . Config::get('yupi.domain') . $url;
    return $url;
  }

  public static function byCode($code) {
    return CardInstance::where('code', '=', $code)->first();
  }
}
