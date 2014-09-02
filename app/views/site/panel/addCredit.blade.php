@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('site.add_credit') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')

@include('site/panel/menu')
<div class="row">&nbsp;</div>
<div class="row">
  <div class="col-sm-6">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">
          <span class="glyphicon glyphicon-credit-card"></span> {{{ Lang::get('panel.using_paypal') }}}
        </h3>
      </div>
      <div class="panel-body">
        <ol>
          <li>{{{ Lang::get('panel.paypal_msg1') }}}</li>
          <li>{{{ Lang::get('panel.paypal_msg2') }}}</li>
          <li>{{{ Lang::get('panel.paypal_msg3') }}}</li>
        </ol>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
    <div class="panel panel-default">
    <form method="POST" accept-charset="UTF-8">
      <div class="panel-body">
        <div class="form-group">
          <label for="amount">
            {{{ Lang::get('panel.amount_label') }}}
            <span class="label label-default visible-xs">@if(Auth::user()->location == 1) {{{Lang::get('site.mexican_pesos')}}} @else {{{Lang::get('site.us_dollars')}}} @endif</span>
          </label>
          <div class="input-group">
            <span class="input-group-addon">$</span>
            <input type="number" name="amount" id="amount" min="0" max="5000" class="form-control" value="{{{ Input::old('amount') }}}">
            <span class="input-group-addon">.00</span>
            <span class="input-group-addon hidden-xs">@if(Auth::user()->location == 1) {{{Lang::get('site.mexican_pesos')}}} @else {{{Lang::get('site.us_dollars')}}} @endif</span>
          </div>
        </div>
        <div class="form-group text-center">
          <button type="submit" class="btn btn-primary one-click">
            {{{ Lang::get('panel.add_credit_paypal_btn') }}}
          </button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>

@stop

@section('scripts')
  <script src="{{asset('assets/js/useCredit.js')}}"></script>
@stop
