@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('site.transactions') }}} ::
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
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title text-center">{{{ Lang::get('panel.transaction') }}}</h3>
      </div>
      @if ($transactions->count())
      <table class="table table-striped" id="dataTable">
        <thead>
          <tr>
            <th>{{{ Lang::get('panel.date') }}}</th>
            <th>{{{ Lang::get('panel.concept') }}}</th>
            <th>{{{ Lang::get('panel.amount') }}}</th>
            <th>{{{ Lang::get('panel.reference') }}}</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($transactions as $txn)
          <tr>
            <td>{{{ date("d M Y H:i:s",strtotime($txn->created_at)) }}}</td>
            <td>@if($txn->type == Transaction::TYPE_ADD_CREDIT)
                  {{{ Lang::get('panel.txn_type_add') }}}
                  @if($txn->mean == Transaction::MEAN_ADD_CREDIT_PAYPAL)
                    - PayPal
                  @endif
                @else
                  {{{ Lang::get('panel.txn_type_use') }}}
                  @if($txn->mean == Transaction::MEAN_USE_CREDIT_GIFT)
                    - {{{ Lang::get('panel.txn_mean_card') }}}
                  @endif
                @endif
            </td>
            <td>${{{ $txn->amount }}}</td>
            <td>{{{ $txn->target_info }}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      @else
      <div class="panel-body text-center">
        {{{ Lang::get('panel.no_transactions') }}}
      </div>
      @endif
    </div>
  </div>
</div>

@stop

@section('scripts')
  <script src="{{asset('assets/js/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('assets/js/dataTables.bootstrap.js')}}"></script>
  <script src="{{asset('assets/js/history.js')}}"></script>
@stop
