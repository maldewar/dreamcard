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
  <div class="col-sm-4">
    @if($total_unclaimed > 0)
    <div class="alert alert-warning alert-block">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      {{{ Lang::get('panel.unclaimed_cards_msg2') }}}
    </div>
    @endif
    @if (Auth::user()->credit == 0)
    <div class="alert alert-warning alert-block">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>{{{ Lang::get('panel.no_credit') }}}</strong> {{{ Lang::get('panel.no_credit_cards') }}}
    </div>
    @endif
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">
          <span class="glyphicon glyphicon-credit-card"></span> {{{ Lang::get('panel.select_a_giftcard') }}}
        </h3>
      </div>
      <div class="panel-body">
        <ol>
          <li>{{{ Lang::get('panel.select_a_giftcard_msg1') }}}</li>
          <li>{{{ Lang::get('panel.select_a_giftcard_msg2') }}}</li>
        </ol>
      </div>
    </div>
  </div>
  <div class="col-sm-8">
    <div class="panel panel-default">
      <div class="panel-body dc-cards">
        <div class="row">
          <div class="col-md-6 col-lg-4 text-left">
            <div class="panel alert alert-info">
            {{{ Lang::get('panel.yupicard_info') }}}
            </div>
          </div>
          <div class="col-md-6 col-lg-4">
            <div class="panel panel-default dc-card" data-url="{{{ URL::action('PanelController@useCreditCard', ['card' => $yupiCard->id]) }}}">
              <div class="panel-body">
                <img src="{{{ $yupiCard->getImage() }}}" style="width:100%"/>
              </div>
              <div class="panel-footer text-center">
              {{{ $yupiCard->name }}}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="panel panel-default">
      <div class="panel-body dc-cards">
        <div class="row">
          <div class="col-md-6 col-lg-4 text-left">
            <div class="panel alert alert-info">
            {{{ Lang::get('panel.retailcard_info') }}}
            </div>
          </div>
          @foreach ($cards as $card)
          <div class="col-md-6 col-lg-4">
            <div class="panel panel-default dc-card" data-url="{{{ URL::action('PanelController@useCreditCard', ['card' => $card->id]) }}}">
              <div class="panel-body">
                <img src="{{{ $card->getImage() }}}" style="width:100%"/>
              </div>
              <div class="panel-footer text-center">
              {{{ $card->name }}}
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

@stop

@section('scripts')
  <script src="{{asset('assets/js/useCredit.js')}}"></script>
@stop
