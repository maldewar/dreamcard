<?php

class Transaction extends Eloquent {
  const TYPE_ADD_CREDIT = 1;
  const TYPE_USE_CREDIT = 2;

  const MEAN_ADD_CREDIT_PAYPAL = 1;
  const MEAN_USE_CREDIT_GIFT = 1;

	protected $guarded = array();

	public static $rules = array(
		'user_id' => 'required',
		'type' => 'required',
		'mean' => 'required',
		'credit' => 'required',
		'amount' => 'required',
		'target_info' => 'required',
		'target_user_id' => 'required',
		'target_card_id' => 'required'
	);
}
