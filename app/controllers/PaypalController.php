<?php

class PaypalController extends BaseController {

    /**
     * object to authenticate the call.
     * @param object $_apiContext
     */
  private $_apiContext;
  private $_paymentId;

    /**
     * Set the ClientId and the ClientSecret.
     * @param 
     *string $_ClientId
     *string $_ClientSecret
     */
    private $_ClientId='AZwVBRA8SljoR5W6zChOz-29qkI-WJtcTGYVQgEXNfxVIrrL7r7xzZR4ChTx';
    private $_ClientSecret='ELYUZRBb3bU86XP-KijD5WTKsyNigewzwVhumK3tzih9HLfT6t3vgaSngphk';

    /*
     *   These construct set the SDK configuration dynamiclly, 
     *   If you want to pick your configuration from the sdk_config.ini file
     *   make sure to update you configuration there then grape the credentials using this code :
     *   $this->_cred= Paypalpayment::OAuthTokenCredential();
    */
    public function __construct()
    {
        // ### Api Context
        // Pass in a `ApiContext` object to authenticate 
        // the call. You can also send a unique request id 
        // (that ensures idempotency). The SDK generates
        // a request id if you do not pass one explicitly. 

        $this->_apiContext = Paypalpayment:: ApiContext(
            Paypalpayment::OAuthTokenCredential(
                $this->_ClientId,
                $this->_ClientSecret
            )
          );

        $this->_paymentId = Session::get('paymentId');

        // dynamic configuration instead of using sdk_config.ini

        $this->_apiContext->setConfig(array(
            'mode' => 'sandbox',
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => __DIR__.'/../PayPal.log',
            'log.LogLevel' => 'FINE'
        ));

    }

    public function create()
    {
      if (isset($_POST['amount'])) {
        $_amount = floatval($_POST['amount']);
      } else {
        $_amount = 0;
      }
      if ($_amount <= 0) {
        return Redirect::action('PanelController@addCredit')
                    ->withInput(Input::except('amount'))
                    ->with('error', Lang::get('panel.error_minimum_add'));
      }
      $payer = Paypalpayment::Payer();
      $payer->setPayment_method("paypal");

      $amount = Paypalpayment:: Amount();
      $currency = 'USD';
      if (Auth::user()->location == 1)
        $currency = 'MXN';
      $amount->setCurrency($currency);
      $amount->setTotal($_amount);

      $transaction = Paypalpayment:: Transaction();
      $transaction->setAmount($amount);
      if (App::getLocale() == 'es')
        $transaction->setDescription("Compra de saldo YupiCard por $" . $_amount . ' ' . $currency . '.');
      else
        $transaction->setDescription('YupiCard credit acquisition for $' . $_amount . ' ' . $currency . '.');

      $baseUrl = Request::root();
      $redirectUrls = Paypalpayment:: RedirectUrls();
      $redirectUrls->setReturn_url($baseUrl.'/addCredit/confirm');
      $redirectUrls->setCancel_url($baseUrl.'/addCredit/cancel');

      $payment = Paypalpayment:: Payment();
      $payment->setIntent("sale");
      $payment->setPayer($payer);
      $payment->setRedirectUrls($redirectUrls);
      $payment->setTransactions(array($transaction));

      $response = $payment->create($this->_apiContext);

      //set the trasaction id , make sure $_paymentId var is set within your class
      $this->_paymentId = $response->id;
      Session::put('paymentId', $this->_paymentId);

      //dump the repose data when create the payment
      $redirectUrl = $response->links[1]->href;

      //this is will take you to complete your payment on paypal
      //when you confirm your payment it will redirect you back to the rturned url set above
      //inmycase sitename/payment/confirmpayment this will execute the getConfirmpayment function bellow
      //the return url will content a PayerID var
      return Redirect::to( $redirectUrl );
    }

    public function getConfirmPayment()
    {
        $payer_id = Input::get('PayerID');
        $payment = Paypalpayment::get($this->_paymentId, $this->_apiContext);
        $paymentExecution = Paypalpayment::PaymentExecution();
        $paymentExecution->setPayer_id( $payer_id );
        $executePayment = $payment->execute($paymentExecution, $this->_apiContext);
        $credit = Auth::user()->credit;
        $amount = $executePayment->transactions[0]->amount->total;
        $txn = new Transaction;
        $txn->user_id = Auth::user()->id;
        $txn->type = Transaction::TYPE_ADD_CREDIT;
        $txn->mean = Transaction::MEAN_ADD_CREDIT_PAYPAL;
        $txn->credit = $credit;
        $txn->amount = $amount;
        $txn->target_info = $executePayment->transactions[0]->related_resources[0]->sale->id;
        $txn->target_user_id = 0;
        $txn->target_card_id = 0;
        DB::table('users')->where('id', Auth::user()->id)
          ->update(array('credit' => $credit + $amount));
        Auth::user()->credit = $credit + $amount;
        $txn->save();

        return View::make('site/panel/addCreditSuccess', array('tab' => 'addCredit',
                                                           'txn' => $txn));
    }

    public function getCancelPayment()
    {
      return Redirect::action('PanelController@addCredit')
                    ->withInput(Input::except('amount'))
                    ->with('error', Lang::get('panel.error_cancel_transaction'));
    }
}
