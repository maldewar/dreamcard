<?php

class PanelController extends BaseController {
  public function __construct() {
    $this->beforeFilter('auth');
  }

  public function useCredit() {
    /*
    $admin = new Role;
    $admin->name = 'Admin';
    $admin->save();

    $manageCards = new Permission;
    $manageCards->name = 'manage_cards';
    $manageCards->display_name = 'Manage Cards';
    $manageCards->save();

    $manageUsers = new Permission;
    $manageUsers->name = 'manage_users';
    $manageUsers->display_name = 'Manage Users';
    $manageUsers->save();

    $admin->perms()->sync(array($manageCards->id, $manageUsers->id));

    $user = User::where('username','=','maldewar')->first();
    $admin = Role::where('name','=', 'Admin')->first();

    $user->attachRole( $admin );
     */
    $cards = Card::where('active', '=', '1')->get();
    $yupiCard = Card::yupiCard();

    return View::make('site/panel/useCredit', array('tab' => 'useCredit',
                                                    'yupiCard' => $yupiCard,
                                                    'cards' => $cards));
  }

  public function useCreditCard($id) {
    if ($id == 0) {
      $card = Card::yupiCard();
    } else {
      $card = Card::find($id);
    }
    if ($card) {
      $contacts = Auth::user()->getContacts();
      return View::make('site/panel/useCreditCard', array('tab' => 'useCredit',
        'card' => $card,
        'contacts'=> $contacts));
    }
    return Redirect::to('useCredit');
  }

  public function useCreditCardPost($id) {
    if ($id == 0) {
      $card = Card::yupiCard();
    } else {
      $card = Card::find($id);
    }
    if ($card) {
      $amount = floatval($_POST['amount']);
      $min_amount = 5.00;
      if ($amount > Auth::user()->credit) {
        // Not enough credit.
        return Redirect::action('PanelController@useCreditCard', array($id))
          ->withInput(Input::except('amount'))
          ->with('error', Lang::get('panel.error_insufficient_credit', array('credit' => Auth::user()->credit)));
      }
      if ($amount < $min_amount) {
        // Minimum transaction value.
        return Redirect::action('PanelController@useCreditCard', array($id))
          ->withInput(Input::except('amount'))
          ->with('error', Lang::get('panel.error_minimum_transaction', array('minimum' => $min_amount)));
      }
      $send_to = intval($_POST['send_to']);
      if (isset($_POST['email']) && $_POST['email'] == Auth::user()->email) {
        $send_to = 0;
      }
      $email = '';
      if ($send_to == 0) {
        /**
         * Send to Me.
         */
        if ($id == 0) {
          // Cannot send credit to oneself.
          return Redirect::action('PanelController@useCreditCard', array($id))
            ->withInput(Input::except('email'))
            ->with('error', Lang::get('panel.error_self_yupicard'));
        }
        // Remove Credit from the user.
        $credit = Auth::user()->credit;
        Auth::user()->credit = $credit - $amount;
        DB::table('users')->where('id', Auth::user()->id)
          ->update(array('credit'=> $credit - $amount));

        // Create Card instance.
        $card_instance = new CardInstance;
        $card_instance->code = hash('md5', time() . Auth::user()->id);
        $card_instance->from_user_id = Auth::user()->id;
        $card_instance->amount = $amount;
        $card_instance->currency = Auth::user()->location;
        $card_instance->to_user_email = Auth::user()->email;
        $card_instance->to_user_id = Auth::user()->id;
        $card_instance->card_id = $id;
        $card_instance->status = CardInstance::STATUS_CLAIMED;
        $card_instance->save();

        // Save Transaction History
        $txn = new Transaction;
        $txn->user_id = Auth::user()->id;
        $txn->type = Transaction::TYPE_USE_CREDIT;
        $txn->mean = Transaction::MEAN_USE_CREDIT_GIFT;
        $txn->credit = $credit;
        $txn->amount = $amount;
        $txn->target_info = Auth::user()->email;
        $txn->target_user_id = Auth::user()->id;
        $txn->target_card_id = $id;
        $txn->save();

        $card_sent_data = array('user' => Auth::user(),
          'card' => $card,
          'card_instance' => $card_instance,
          'amount' => $amount);
        Mail::send('emails.card_sent_self', $card_sent_data, function($message)
        {
          $message->to(Auth::user()->email, Auth::user()->firstname . ' ' . Auth::user()->lastname)
            ->subject(Lang::get('email.card_sent_self_title'));
        });

      } else {
        /**
         * Send To email/User.
         */
        $email = $_POST['email'];
        $email_validator = Validator::make(array('email'=>$email),array('email'=>'required|email'));
        if ($email_validator->fails()) {
          return Redirect::action('PanelController@useCreditCard', array($id))
            ->withInput(Input::except('email'))
            ->with('error', Lang::get('panel.error_email'));
        }

        // Remove Credit from the user.
        $credit = Auth::user()->credit;
        Auth::user()->credit = $credit - $amount;
        DB::table('users')->where('id', Auth::user()->id)
          ->update(array('credit'=> $credit - $amount));

        // Create Card instance.
        $card_instance = new CardInstance;
        $card_instance->code = hash('md5', time() . Auth::user()->id);
        $card_instance->from_user_id = Auth::user()->id;
        $card_instance->amount = $amount;
        $card_instance->currency = Auth::user()->location;
        $card_instance->to_user_email = $email;
        $card_instance->card_id = $id;

        // Check if recipient exists.
        $recipient_user = User::byEmail($email);
        $recipient_user_id = 0;
        if (is_null($recipient_user)) {
          // Invite user to subscribe.
          $card_instance->to_user_id = 0;
        } else {
          $card_instance->to_user_id = $recipient_user->id;
          $recipient_user_id = $recipient_user->id;
        }
        $card_instance->save();

        // Save Transaction History
        $txn = new Transaction;
        $txn->user_id = Auth::user()->id;
        $txn->type = Transaction::TYPE_USE_CREDIT;
        $txn->mean = Transaction::MEAN_USE_CREDIT_GIFT;
        $txn->credit = $credit;
        $txn->amount = $amount;
        $txn->target_info = $email;
        $txn->target_user_id = $recipient_user_id;
        $txn->target_card_id = $id;
        $txn->save();

        // Add Contact
        Auth::user()->addContact($email);

        // Send mail to SENDER.
        $card_sent_data = array('sender' => Auth::user(),
          'card' => $card,
          'card_instance' => $card_instance,
          'amount' => $amount,
          'sendername' => Auth::user()->username,
          'recipient_user_email' => $email);
        Mail::send('emails.card_sent', $card_sent_data, function($message)
        {
          $message->to(Auth::user()->email, Auth::user()->firstname . ' ' . Auth::user()->lastname)
            ->subject(Lang::get('email.card_sent_title'));
        });

        // Send mail to RECIPIENT.
        if (is_null($recipient_user)) {
          Mail::send('emails.card_received_register', $card_sent_data, function($message) use($email)
          {
            $message->to($email, '')->subject(Lang::get('email.card_received_title'));
          });
        } else {
          Mail::send('emails.card_received', $card_sent_data, function($message) use ($email)
          {
            $message->to($email, '')->subject(Lang::get('email.card_received_title'));
          });
        }
      }
      return View::make('site/panel/useCreditCardSuccess', array('tab' => 'useCredit',
        'card' => $card,
        'card_instance' => $card_instance,
        'send_to' => $send_to,
        'amount' => $amount,
        'email' => $email,
        'currency' => (Auth::user()->location == 1?'MXN':'USD')));
    } else {
      return Redirect::to('useCredit')
        ->with('error', Lang::get('panel.error_card_not_found'));
    }
    return Redirect::to('useCredit')
      ->with('error', Lang::get('panel.error_use_card_general'));
  }

	public function addCredit() {
		return View::make('site/panel/addCredit', array('tab' => 'addCredit'));
  }

  public function addCreditPost() {

    // Simulate a $10 transaction with PayPal.
    
    //$amount = rand(5,15);
    if (isset($_POST['amount'])) {
      $amount = floatval($_POST['amount']);
    } else {
      $amount = 0;
    }
    if ($amount <= 0) {
      return Redirect::action('PanelController@addCreditPost')
                  ->withInput(Input::except('amount'))
                  ->with('error', Lang::get('panel.error_minimum_add'));
    }
    $credit = Auth::user()->credit;
    $txn = new Transaction;
    $txn->user_id = Auth::user()->id;
    $txn->type = Transaction::TYPE_ADD_CREDIT;
    $txn->mean = Transaction::MEAN_ADD_CREDIT_PAYPAL;
    $txn->credit = $credit;
    $txn->amount = $amount;
    $txn->target_info = hash('md5', time() . Auth::user()->id);
    $txn->target_user_id = 0;
    $txn->target_card_id = 0;
    DB::table('users')->where('id', Auth::user()->id)
      ->update(array('credit' => $credit + $amount));
    Auth::user()->credit = $credit + $amount;
    $txn->save();

    return View::make('site/panel/addCreditSuccess', array('tab' => 'addCredit',
                                                           'txn' => $txn));
  }

  public function myCards() {
    $received_cards  = DB::table('card_instances')
                    ->leftJoin('cards', 'card_instances.card_id', '=', 'cards.id')
                    ->leftJoin('users', 'card_instances.from_user_id', '=', 'users.id')
                    ->select('card_instances.id', 'card_instances.card_id', 'card_instances.amount', 'card_instances.code',
                             'card_instances.from_user_id', 'card_instances.status', 'card_instances.created_at',
                             'card_instances.currency', 'cards.name as cardname', 'users.email as from_user_email')
                             ->where('card_instances.to_user_id','=', Auth::user()->id)
                             ->orderBy('card_instances.created_at', 'desc')->get();
    $sent_cards = DB::table('card_instances')
                    ->leftJoin('cards', 'card_instances.card_id', '=', 'cards.id')
                    ->select('card_instances.id', 'card_instances.card_id', 'card_instances.amount', 'card_instances.code',
                             'card_instances.to_user_email', 'card_instances.status', 'card_instances.created_at',
                             'card_instances.currency', 'cards.name as cardname')
                             ->where('card_instances.from_user_id','=', Auth::user()->id)
                             ->orderBy('card_instances.created_at', 'desc')->get();
    $unclaimed_cards_count = DB::table('card_instances')
                                ->select('id')
                                ->where('to_user_id', '=', Auth::user()->id)
                                ->where('status', '=', CardInstance::STATUS_NOT_CLAIMED);
    return View::make('site/panel/myCards', array('tab' => 'myCards',
      'received_cards' => $received_cards,
      'sent_cards' => $sent_cards,
      'total_received_cards' => sizeof($received_cards),
      'total_sent_cards' => sizeof($sent_cards),
      'total_unclaimed' => $unclaimed_cards_count->count()));
  }

  public function history() {
    //$transactions = Transaction::select(array('transactions.id','transactions.type','transactions.amount', 'posts.created_at'));
    $transactions = Transaction::where('user_id', '=', Auth::user()->id)->get();
    return View::make('site/panel/history', array('tab' => 'history', 'transactions' => $transactions));
  }

  public function viewCard($code) {
    $cardInstance = CardInstance::byCode($code);
    if (!is_null($cardInstance) && $cardInstance->to_user_id == Auth::user()->id) {
      if ($cardInstance->status == CardInstance::STATUS_NOT_CLAIMED) {
        return Redirect::to('myCards/' . $code . '/claim');
      }
      if ($cardInstance->card_id == 0) {
        $card = Card::yupiCard();
      } else {
        $card = Card::find($cardInstance->card_id);
      }
      if ($card) {
        $sender = User::find($cardInstance->from_user_id);
        return View::make('site/panel/viewCard', array('tab' => 'myCards',
                            'sender' => $sender,
                            'card' => $card,
                            'card_instance' => $cardInstance));
      }
    }
    return Redirect::to('myCards')
            ->with('error', Lang::get('panel.error_not_found_card_instance'));
  }

  public function claimCard($code) {
    $cardInstance = CardInstance::byCode($code);
    if (!is_null($cardInstance) && $cardInstance->to_user_id == Auth::user()->id) {
      if ($cardInstance->status == CardInstance::STATUS_CLAIMED) {
        return Redirect::to('myCards/' . $code);
      }
      if ($cardInstance->card_id == 0) {
        $card = Card::yupiCard();
      } else {
        $card = Card::find($cardInstance->card_id);
      }
      if ($card) {
        $sender = User::find($cardInstance->from_user_id);
        return View::make('site/panel/claimCard', array('tab' => 'myCards',
                            'sender' => $sender,
                            'card' => $card,
                            'card_instance' => $cardInstance));
      }
    }
    return Redirect::to('myCards')
            ->with('error', Lang::get('panel.error_not_found_card_instance'));
  }

  public function claimCardPost($code) {
    $cardInstance = CardInstance::byCode($code);
    if (!is_null($cardInstance) && $cardInstance->to_user_id == Auth::user()->id) {
      if ($cardInstance->status == CardInstance::STATUS_CLAIMED) {
        return Redirect::to('myCards/' . $code);
      }
      if ($cardInstance->card_id == 0) {
        $card = Card::yupiCard();
        $convertion = false;
        $amount = $cardInstance->amount;
        $amount_after_convertion = $cardInstance->amount;
        if (Auth::user()->location != $cardInstance->currency) {
          $convertion = true;
          if ($cardInstance->currency == 1) {
            $amount_after_convertion = $amount * Config::get('yupi.mxn_to_usd');
          } else {
            $amount_after_convertion = $amount * Config::get('yupi.usd_to_mxn');
          }
        }
        $credit = Auth::user()->credit;
        Auth::user()->credit = $credit + $amount_after_convertion;
        DB::table('users')->where('id', Auth::user()->id)
          ->update(array('credit'=> $credit + $amount_after_convertion));
        $sender = User::find($cardInstance->from_user_id);
        $cardInstance->status = CardInstance::STATUS_CLAIMED;
        $cardInstance->save();
        $notice_data = array('sender' => $sender,
          'recipient' => Auth::user(),
          'card' => $card,
          'card_instance' => $cardInstance,
          'amount_before' => $amount,
          'amount_after' => $amount_after_convertion,
          'convertion' => $convertion);
        Mail::send('emails.card_notice', $notice_data, function($message) use($sender)
        {
          $message->to($sender->email, $sender->first_name . ' ' . $sender->last_name)
            ->subject(Lang::get('email.card_notice_title'));
        });
        return View::make('site/panel/viewCard', array('tab' => 'myCards',
                            'sender' => $sender,
                            'card' => $card,
                            'card_instance' => $cardInstance));
        
      } else {
        $card = Card::find($cardInstance->card_id);
        $cardInstance->status = CardInstance::STATUS_CLAIMED;
        $cardInstance->save();
        $sender = User::find($cardInstance->from_user_id);
        $notice_data = array('sender' => $sender,
          'recipient' => Auth::user(),
          'card' => $card,
          'card_instance' => $cardInstance);
        Mail::send('emails.card_notice', $notice_data, function($message) use($sender)
        {
          $message->to($sender->email, $sender->first_name . ' ' . $sender->last_name)
            ->subject(Lang::get('email.card_notice_title'));
        });
        return View::make('site/panel/viewCard', array('tab' => 'myCards',
                            'sender' => $sender,
                            'card' => $card,
                            'card_instance' => $cardInstance));
      }
    }
    return Redirect::to('myCards')
            ->with('error', Lang::get('panel.error_not_found_card_instance'));
  }

  public function settings() {
    return View::make('site/panel/settings', array('tab' => 'settings'));
  }

}
