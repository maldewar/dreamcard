<ul class="nav nav-tabs" role="tablist">
  <li class="@if($tab == 'useCredit') active @endif"><a href="{{{ URL::to('useCredit') }}}">{{{ Lang::get('site.use_credit') }}}</a></li>
  <li class="@if($tab == 'addCredit') active @endif"><a href="{{{ URL::to('addCredit') }}}">{{{ Lang::get('site.add_credit') }}}</a></li>
  <li class="@if($tab == 'myCards') active @endif hidden-xs"><a href="{{{URL::to('myCards')}}}">{{{ Lang::get('site.my_cards') }}}</a></li>
  <li class="@if($tab == 'history') active @endif hidden-xs"><a href="{{{ URL::to('history') }}}">{{{ Lang::get('site.transactions') }}}</a></li>
  <li class="@if($tab == 'settings') active @endif hidden-xs"><a href="{{{ URL::to('settings') }}}">{{{ Lang::get('site.settings') }}}</a></li>
  <li class="dropdown visible-xs @if($tab == 'history' || $tab == 'settings' || $tab == 'myCards') active @endif">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
      {{{Lang::get('site.more')}}} <span class="caret"></span>
    </a>
    <ul class="dropdown-menu dropdown-menu-right" role="menu">
      <li><a href="{{{ URL::to('myCards') }}}">{{{ Lang::get('site.my_cards') }}}</a></li>
      <li><a href="{{{ URL::to('history') }}}">{{{ Lang::get('site.transactions') }}}</a></li>
      <li><a href="{{{ URL::to('settings') }}}">{{{ Lang::get('site.settings') }}}</a></li>
    </ul>
  </li>
</ul>
