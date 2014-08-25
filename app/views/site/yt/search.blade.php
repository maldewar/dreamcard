@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('site.use_credit') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')

<div class="row">&nbsp;</div>
<div class="row">
  <div class="col-xs-12">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">
          <span class="glyphicon glyphicon-credit-card"></span> Search Results for 'Me Singing'
        </h3>
      </div>
      <div class="panel-body">
        <div>Next Page: <a id="nextPage" href="{{ URL::to('youtube/consume') }}?page_token={{{$page_token}}}">{{{$page_token}}}</a></div>
        <div>
          <ul>
          {{ $result }}
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>

@stop

@section('scripts')
  <script src="{{asset('assets/js/useCredit.js')}}"></script>
  <script type="text/javascript">
$('document').ready(function(){
  //setTimeout('getNextPage()', 5000);
});
function getNextPage() {
  var nextPageURL = $('#nextPage').attr('href');
  location.href = nextPageURL;
}
  </script>
@stop
