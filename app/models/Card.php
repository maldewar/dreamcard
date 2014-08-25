<?php

class Card extends Eloquent {
	protected $guarded = array('image');

	public static $rules = array(
		'name' => 'required',
		'location' => 'required',
		'active' => 'required',
		'desc_en' => 'required',
		'desc_es' => 'required'
  );

  public static function yupiCard() {
    $yupiCard = new Card;
    $yupiCard->id = 0;
    $yupiCard->name = 'YupiCard';
    $yupiCard->location = 0;
    $yupiCard->active = true;
    $yupiCard->desc_en = 'YupiCard lets you transfer credit to other users so they can purchase cards from our store catalog.';
    $yupiCard->desc_es = 'YupiCard te permite transferir crédito a otros usuarios para que pueda adquirir tarjetas de tiendas en nuestro catálogo.';
    return $yupiCard;
  }

  public function getLocation() {
    switch($this->location) {
      case 1:
        return "MX";
      case 2:
        return "US";
    }
    return "MX|US";
  }

  public function getSmallThumb() {
    return asset('uploads/cards/' . $this->id . '/50x50_crop/card.jpg');
  }

  public function getThumb() {
    return asset('uploads/cards/' . $this->id . '/100x100_crop/card.jpg');
  }

  public function getImage() {
    return asset('uploads/cards/' . $this->id . '/300x200_crop/card.jpg');
  }
}
