@if (Auth::check())
<p>
<div class="btn-group btn-block">
  <button type="button" class="col-xs-12 btn btn-primary btn-lg dropdown-toggle" data-toggle="dropdown">
    <div class="text-left">
    {{{Auth::user()->first_name . ' ' . Auth::user()->last_name }}}
    @if(Auth::user()->hasRole('Admin'))
    <span><small>(Administrator)</small></span>
    @endif
    </div>
    <div class="text-right">
      <span class="label label-info"><small>@if(Auth::user()->location == 1){{{Lang::get('site.mexican_pesos')}}}@else{{{Lang::get('site.us_dollars')}}}@endif</small></span>
      <span class="badge">${{{Auth::user()->credit}}}</span> <span class="caret"></span>
    </div>
  </button>
  <ul class="dropdown-menu dropdown-menu-right" role="menu">
    <li><a href="{{{ URL::to('useCredit') }}}">Use Credit</a></li>
    <li><a href="{{{ URL::to('addCredit') }}}">Add Credit</a></li>
    <li><a href="{{{ URL::to('myCards') }}}">My Cards</a></li>
    <li><a href="{{{ URL::to('history') }}}">See Transactions</a></li>
    <li><a href="{{{ URL::to('settings') }}}">Settings</a></li>
    @if (Auth::user()->hasRole('Admin'))
    <li class="divider"></li>
    <li><a href="{{{ URL::to('users') }}}">Manage Users</a></li>
    <li><a href="{{{ URL::to('cards') }}}">Manage Cards</a></li>
    @endif
  </ul>
</div>
</p>
@endif
