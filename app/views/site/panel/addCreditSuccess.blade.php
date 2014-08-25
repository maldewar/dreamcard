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
  <div class="col-sm-12">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title text-center">
          {{{ Lang::get('panel.transaction_successful') }}}
        </h3>
      </div>
      <div class="panel-body">
        <ol>
          <li>{{{ Lang::get('panel.txn_done_msg1') }}}</li>
          <li>{{{ Lang::get('panel.txn_done_msg2') }}}</li>
        </ol>
        <div class="panel panel-default">
          <div class="panel-heading">{{{ Lang::get('panel.transaction') }}}</div>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Date</th>
                <th>Id</th>
                <th>Concept</th>
                <th class="hidden-xs">PayPal Ref.</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{{ date("d M Y",strtotime($txn->created_at)) }}}</td>
                <td>{{{ $txn->id }}}</td>
                <td>PayPal</td>
                <td class="hidden-xs">{{{ $txn->target_info }}}</td>
                <td>${{{ $txn->amount }}}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="text-center">
          {{ link_to('useCredit', Lang::get('panel.use_credit_btn'), array('class'=>'btn btn-primary')) }}
          {{ link_to('history', Lang::get('panel.see_transactions_btn'), array('class'=>'btn btn-default')) }}
        </div>
      </div>
    </div>
  </div>
</div>

@stop

@section('scripts')
  <script src="{{asset('assets/js/useCredit.js')}}"></script>
@stop
