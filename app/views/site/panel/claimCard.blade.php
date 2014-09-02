@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('site.my_cards') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')

@include('site/panel/menu')
<div class="row">&nbsp;</div>
<div class="row">
  <div class="col-sm-4">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">
          <span class="glyphicon glyphicon-credit-card"></span> {{{ Lang::get('panel.your_gift_card') }}}
        </h3>
      </div>
      <div class="panel-body">
        <div class="panel panel-default">
          <img src="{{{ $card->getImage() }}}" style="width:100%"/>
        </div>
        <h4>{{{ $card->name }}}</h4>
        <p class="text-justify">
        @if (Config::get('app.locale') == 'es')
          {{{ $card->desc_es }}}
        @else
          {{{ $card->desc_en }}}
        @endif
        </p>
        <div class="text-right">
          {{ link_to('myCards', Lang::get('panel.return_to_my_cards_btn'), array('class'=>'btn btn-default btn-sm')) }}
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-8">
    <div class="panel panel-default">
      <form method="POST" accept-charset="UTF-8">
      <input type="hidden" value="{{{ $card_instance->code }}}"/>
      <div class="panel-body">
        <div class="form-group">
        </div>
        <div class="form-group">
          <div class="row">
          </div>
          <div class="row">
          </div>
        </div>
        <h3>{{{ Lang::get('panel.card_info_title') }}}</h3>
        <div class="list-group">
          <div class="list-group-item">
             <strong>{{{ Lang::get('panel.card_info_from') }}}:</strong>
             {{{ $sender->first_name . ' ' . $sender->last_name . ' (' . $sender->username . ')'}}}
          </div>
          <div class="list-group-item">
             <strong>{{{ Lang::get('panel.card_info_retail') }}}:</strong>
             {{{ $card->name }}}
          </div>
          <div class="list-group-item">
             <strong>{{{ Lang::get('panel.card_info_received_at') }}}:</strong>
              {{{ date("d M Y H:i:s",strtotime($card_instance->created_at)) }}}
          </div>
          <div class="list-group-item">
            <strong>{{{ Lang::get('panel.card_info_amount') }}}:</strong>
            @if($card_instance->currency == Auth::user()->location)
            ${{{ $card_instance->amount }}} @if($card_instance->currency == 1){{{Lang::get('site.mxn')}}}@else{{{Lang::get('site.usd')}}}@endif
            @else
              @if($card_instance->currency == 1)
                ${{{ $card_instance->amount * Config::get('yupi.mxn_to_usd') }}} USD <span class="label label-warning">$1 mxn = ${{{Config::get('yupi.mxn_to_usd')}}} usd</span>
              @else
                ${{{ $card_instance->amount * Config::get('yupi.usd_to_mxn') }}} MXN <span class="label label-warning">$1 usd = ${{{Config::get('yupi.usd_to_mxn')}}} mxn</span>
              @endif
            @endif
          </div>
        </div>
        @if ($card_instance->currency != Auth::user()->location)
        <div class="alert alert-warning">
          @if ($card_instance->currency == 1)
          {{{ Lang::get('panel.claim_card_currency_msg', array('currency_origin' => Lang::get('site.mexican_pesos'),
                'currency_target' => Lang::get('site.us_dollars'),
                'amount' => $card_instance->amount)) }}}
          @else
          {{{ Lang::get('panel.claim_card_currency_msg', array('currency_origin' => Lang::get('site.us_dollars'),
                'currency_target' => Lang::get('site.mexican_pesos'),
                'amount' => $card_instance->amount)) }}}
          @endif
        </div>
        @endif
        <ol>
          <li>{{{ Lang::get('panel.claim_retail_card_msg1', array('retail' => $card->name)) }}}</li>
          @if ($card_instance->from_user_id != Auth::user()->id)
          <li>{{{ Lang::get('panel.claim_retail_card_msg2') }}}</li>
          @endif
          <li>{{{ Lang::get('panel.claim_retail_card_msg3') }}}</li>
        </ol>
        <div class="form-group text-center">
          <button type="submit" class="btn btn-primary one-click">
            {{{ Lang::get('panel.claim_card_btn') }}} <span class="glyphicon glyphicon-ok"></span>
          </button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>

@stop

@section('scripts')
  <!--script src="{{asset('assets/js/useCreditCard.js')}}"></script-->
@stop
