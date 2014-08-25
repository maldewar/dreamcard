<?php

class YtResult extends Eloquent {
	protected $guarded = array();

	public static $rules = array(
		'video_id' => 'required',
		'url' => 'required',
		'title' => 'required',
		'username' => 'required',
		'user_id' => 'required',
		'user_url' => 'required',
		'views' => 'required',
		'published_at' => 'required',
		'thumb' => 'required'
	);
}
