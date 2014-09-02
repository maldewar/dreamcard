@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('site.use_credit') }}} ::
@parent
@stop

@section('css')
<link rel="stylesheet" href="{{asset('assets/css/selectize.bootstrap3.css')}}">
@stop

{{-- Content --}}
@section('content')

@include('site/panel/menu')
<div class="row">&nbsp;</div>
<div class="row">
  <div class="col-sm-4">
    @if (Auth::user()->credit == 0)
    <div class="alert alert-warning alert-block">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>{{{ Lang::get('panel.no_credit') }}}</strong> {{{ Lang::get('panel.no_credit_card') }}}
    </div>
    @endif
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
          {{ link_to('useCredit', Lang::get('panel.pick_another'), array('class'=>'btn btn-default btn-sm')) }}
        </div>
      </div>
    </div>
  </div>
  <div class="col-sm-8">
    <div class="panel panel-default">
      <form method="POST" accept-charset="UTF-8">
      <div class="panel-body">
        <div class="form-group">
          <label for="amount">
            {{{ Lang::get('panel.amount_label') }}} <span class="badge">${{{ Auth::user()->credit }}} @if(Auth::user()->location == 1) {{{Lang::get('site.mexican_pesos')}}} @else {{{Lang::get('site.us_dollars')}}} @endif {{{ Lang::get('panel.available') }}}</span>
            <!--span class="label label-default visible-xs">@if(Auth::user()->location == 1) {{{Lang::get('site.mexican_pesos')}}} @else {{{Lang::get('site.us_dollars')}}} @endif</span-->
          </label>
          <div class="input-group">
            <span class="input-group-addon">$</span>
            <input type="number" name="amount" id="amount" min="0" max="{{{ Auth::user()->credit }}}" class="form-control" value="{{{ Input::old('amount') }}}">
            <span class="input-group-addon">.00</span>
            <span class="input-group-addon hidden-xs">@if(Auth::user()->location == 1) {{{Lang::get('site.mexican_pesos')}}} @else {{{Lang::get('site.us_dollars')}}} @endif</span>
          </div>
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-xs-12">
              <label>Recipient</label>
            </div>
          </div>
          <div class="row">
            @if($card->id == 0)
            <div class="col-sm-12">
              <div class="panel panel-default alert-info">
                <div class="panel-body text-center">
                  <label class="radio inline"><input type="hidden" name="send_to" value="1"/>{{{ Lang::get('panel.send_to_somebody') }}}</label>
                  <input type="text" name="email" id="email_field" placeholder="email" class="form-control" value="{{{Input::old('email')}}}"></input>
                </div>
              </div>
            </div>
            @else
            <div class="col-sm-6">
              <div class="panel panel-default alert-info">
                <div class="panel-body text-center">
                  <label class="radio inline"><input type="radio" name="send_to" value="1" @if(Input::old('send_to') === 1)checked="checked"@else checked="checked" @endif/>{{{ Lang::get('panel.send_to_somebody') }}}</label>
                  <input type="text" name="email" id="email_field" placeholder="email" class="form-control" value="{{{Input::old('email')}}}"></input>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="panel panel-default alert-info">
                <div class="panel-body text-center">
                  <label class="radio inline"><input type="radio" name="send_to" value="0" @if(Input::old('send_to') === 0)checked="checked"@endif/>{{{ Lang::get('panel.send_to_me') }}}</label>
                </div>
              </div>
            </div>
            @endif
          </div>
        </div>
        <div class="form-group text-center">
          <button type="submit" class="btn btn-primary one-click">
            {{{ Lang::get('panel.send_gift_card') }}} <span class="glyphicon glyphicon-send"></span>
          </button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>

@stop

@section('scripts')
  <script src="{{asset('assets/js/selectize.js')}}"></script>
  <script>
  var contacts = [
      @foreach ($contacts as $contact)
      { email: '{{{ $contact->email }}}' },
      @endforeach
      ];
  </script>
  <script src="{{asset('assets/js/useCreditCard.js')}}"></script>
@stop
