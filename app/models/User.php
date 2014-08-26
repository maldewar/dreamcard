<?php

use Zizaco\Confide\ConfideUser;
use Zizaco\Confide\ConfideUserInterface;
use Zizaco\Entrust\HasRole;

class User extends Eloquent implements ConfideUserInterface
{
  protected $fillable = array('first_name', 'last_name', 'location');
  use ConfideUser;
  use HasRole;

  public static function byEmail($email) {
    return User::where('email', '=', $email)->first();
  }

  public function addContact($email) {
    $contacts = DB::table('user_autocomplete')
                  ->select('user_id', 'count')
                  ->where('user_id', '=', Auth::user()->id)
                  ->where('email', '=', $email)->first();
    if($contacts) {
      /*DB::table('user_autocomplete')
      ->increment('count', 1, array('user_id' => Auth::user()->id, 'email' => $email));*/
      DB::table('user_autocomplete')
        ->where('user_id', '=', Auth::user()->id)
        ->where('email', '=', $email)
        ->update(array('count'=> $contacts->count + 1));
    } else {
      // Register does not exist, create
      // See if contact exists
      $username = '';
      $contact_user = User::byEmail($email);
      if(!is_null($contact_user)) {
        $username = $contact_user->username;
      }
      DB::table('user_autocomplete')
        ->insert(array('user_id' => Auth::user()->id,
          'email' => $email,
          'username' => $username,
          'count' => 1));
    }
  }

  public function getContacts() {
    $contacts = DB::table('user_autocomplete')
      ->select('user_id', 'email', 'username', 'count')
      ->where('user_id', '=', Auth::user()->id)
      ->orderBy('count', 'desc')->get();
    return $contacts;
  }
}
