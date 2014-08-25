@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('site.use_credit') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')

@include('site/panel/menu')
<div class="row">&nbsp;</div>
<div class="row">
  <div class="col-sm-12">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title text-center">
          {{{ Lang::get('panel.transaction_successful') }}}
        </h3>
      </div>
      <div class="panel-body">
        <ol>
          <li>{{{ Lang::get('panel.card_done_msg1', array('amount' => $amount, 'currency' => $currency)) }}}</li>
          @if ($send_to == 0)
          <li>{{{ Lang::get('panel.card_done_to_me_msg') }}}</li>
          @else
          <li>{{{ Lang::get('panel.card_done_to_someone_msg', array('email' => $email)) }}}</li>
          @endif
        </ol>
        <div class="text-center">
          {{ link_to('myCards', Lang::get('panel.see_cards_btn'), array('class'=>'btn btn-primary')) }}
          {{ link_to('history', Lang::get('panel.see_transactions_btn'), array('class'=>'btn btn-default')) }}
        </div>
      </div>
    </div>
  </div>
</div>

@stop

@section('scripts')
@stop
