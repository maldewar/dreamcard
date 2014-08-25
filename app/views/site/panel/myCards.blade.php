@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('site.my_cards') }}} ::
@parent
@stop

@section('css')
<link rel="stylesheet" href="{{asset('assets/css/dataTables.bootstrap.css')}}">
@stop

{{-- Content --}}
@section('content')

@include('site/panel/menu')
<div class="row">&nbsp;</div>
<div class="row">
  <div class="col-sm-12">
    @if($total_unclaimed > 0)
      <div class="alert alert-warning text-center">
        {{{ Lang::get('panel.unclaimed_cards_msg') }}}
      </div>
    @endif
    <div class="panel panel-default">
      <div class="panel-heading text-center">
        <h3 class="panel-title">{{{ Lang::get('panel.received_cards') }}}
        @if($total_received_cards>0)<span class="badge">{{{$total_received_cards}}}</span>@endif</h3>
      </div>
      @if(sizeof($received_cards)>0)
      <table class="table table-striped" id="received_dataTable">
        <thead>
          <tr>
            <th>&nbsp;</th>
            <th>{{{ Lang::get('panel.card') }}}</th>
            <th>{{{ Lang::get('panel.amount') }}}</th>
            <th>{{{ Lang::get('panel.received_from') }}}</th>
            <th>{{{ Lang::get('panel.status') }}}</th>
            <th>{{{ Lang::get('panel.date') }}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($received_cards as $received_card)
          <tr>
            <td class="text-center">
              @if($received_card->status == CardInstance::STATUS_NOT_CLAIMED)
              {{ link_to('myCards/' . $received_card->code . '/claim', Lang::get('panel.claim_card_btn'), array('class'=>'btn btn-primary')) }}
              @else
              {{ link_to('myCards/' . $received_card->code, Lang::get('panel.view_card_btn'), array('class'=>'btn btn-primary')) }}
              @endif
            </td>
            <td>
              @if ($received_card->card_id == 0)
                <strong>YupiCard</strong>
              @else
              {{{ $received_card->cardname }}}
              @endif
            </td>
            <td>${{{ $received_card->amount }}} @if($received_card->currency == 1){{{Lang::get('site.mxn')}}}@else{{{Lang::get('site.usd')}}}@endif</td>
            <td>@if($received_card->from_user_email == Auth::user()->email) {{{ Lang::get('panel.sent_to_self') }}} @else {{{ $received_card->from_user_email}}} @endif</td>
            <td>@if($received_card->status==0){{{Lang::get('panel.status_unclaimed')}}}@else{{{Lang::get('panel.status_claimed')}}}@endif</td>
            <td>{{{ date("d M Y H:i:s",strtotime($received_card->created_at)) }}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @else
      <div class="panel-body text-center">
        {{{ Lang::get('panel.no_received_cards') }}}
      </div>
      @endif
    </div>
  </div>
  <div class="col-sm-12">
    <div class="panel panel-default">
      <div class="panel-heading text-center">
        <h3 class="panel-title">{{{ Lang::get('panel.sent_cards') }}}
        @if($total_sent_cards>0)<span class="badge">{{{$total_sent_cards}}}</span>@endif</h3>
      </div>
      @if(sizeof($sent_cards)>0)
      <table class="table table-striped" id="sent_dataTable">
        <thead>
          <tr>
            <th>{{{ Lang::get('panel.card') }}}</th>
            <th>{{{ Lang::get('panel.amount') }}}</th>
            <th>{{{ Lang::get('panel.sent_to') }}}</th>
            <th>{{{ Lang::get('panel.status') }}}</th>
            <th>{{{ Lang::get('panel.date') }}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($sent_cards as $sent_card)
          <tr>
            <td>
              @if ($sent_card->card_id == 0)
                <strong>YupiCard</strong>
              @else
              {{{ $sent_card->cardname }}}
              @endif
            </td>
            <td>${{{ $sent_card->amount }}} @if($sent_card->currency == 1){{{Lang::get('site.mxn')}}}@else{{{Lang::get('site.usd')}}}@endif</td>
            <td>{{{ $sent_card->to_user_email}}}</td>
            <td>@if($sent_card->status==0){{{Lang::get('panel.status_unclaimed')}}}@else{{{Lang::get('panel.status_claimed')}}}@endif</td>
            <td>{{{ date("d M Y H:i:s",strtotime($sent_card->created_at)) }}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @else
      <div class="panel-body text-center">
        {{{ Lang::get('panel.no_sent_cards') }}}
      </div>
      @endif
    </div>
  </div>
</div>

@stop

@section('scripts')
  <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('assets/js/dataTables.bootstrap.js')}}"></script>
  <script src="{{asset('assets/js/myCards.js')}}"></script>
@stop
