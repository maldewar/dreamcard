<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Basic Page Needs
		================================================== -->
		<meta charset="utf-8" />
		<title>
			@section('title')
			YupiCard
			@show
		</title>
		<meta name="keywords" content="your, awesome, keywords, here" />
		<meta name="author" content="Valdemar Sanchez" />
		<meta name="description" content="Lorem ipsum dolor sit amet, nihil fabulas et sea, nam posse menandri scripserit no, mei." />

		<!-- Mobile Specific Metas
		================================================== -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<!-- CSS
		================================================== -->
        <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap-theme.min.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/site.css')}}">
        @yield('css')

		<style>
        body {
            padding: 60px 0;
        }
		@section('styles')
		@show
		</style>

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- Favicons
		================================================== -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{{ asset('assets/ico/apple-touch-icon-144-precomposed.png') }}}">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{{ asset('assets/ico/apple-touch-icon-114-precomposed.png') }}}">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{{ asset('assets/ico/apple-touch-icon-72-precomposed.png') }}}">
		<link rel="apple-touch-icon-precomposed" href="{{{ asset('assets/ico/apple-touch-icon-57-precomposed.png') }}}">
		<link rel="shortcut icon" href="{{{ asset('assets/ico/favicon.png') }}}">
	</head>

	<body>
		<!-- To make sticky footer need to wrap in a div -->
		<div id="wrap">
		<!-- Navbar -->
		<div class="navbar navbar-default navbar-inverse navbar-fixed-top">
			 <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav">
						<li {{ (Request::is('/') ? ' class="active"' : '') }}><a href="{{{ URL::to('') }}}">{{{ Lang::get('site.home') }}}</a></li>
					</ul>

                    <ul class="nav navbar-nav pull-right">
                        @if (Auth::check())
                        @if (Auth::user()->hasRole('admin'))
                        <li><a href="{{{ URL::to('admin') }}}">{{{ Lang::get('site.admin_panel') }}}</a></li>
                        @endif
                        <li><a href="{{{ URL::to('user') }}}">{{{ Lang::get('site.logged_in_as') }}} {{{ Auth::user()->username }}}</a></li>
                        <li><a href="{{{ URL::to('users/logout') }}}">{{{ Lang::get('site.logout') }}}</a></li>
                        @else
                        <li {{ (Request::is('users/login') ? ' class="active"' : '') }}><a href="{{{ URL::to('users/login') }}}">{{{ Lang::get('site.login') }}}</a></li>
                        <li {{ (Request::is('user/register') ? ' class="active"' : '') }}><a href="{{{ URL::to('users/create') }}}">{{{ Lang::get('site.sign_up') }}}</a></li>
                        @endif
                        <li class="dropdown">
   <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ Lang::get( 'site.language' ) }} <b class="caret"></b></a>
    <ul class="dropdown-menu">
     @foreach( array('en' => 'English', 'es' => 'Español') as $mKey => $mLanguage )
      <li>{{ HTML::linkAction( 'BaseController@setLocale', $mLanguage, $mKey ) }}</li>
     @endforeach
    </ul>
   </li>
                    </ul>
					<!-- ./ nav-collapse -->
				</div>
			</div>
		</div>
    <!-- ./ navbar -->

    <!-- User Card -->
    <div class="container">
      @include('usercard')
    </div>
    <!-- ./ user card -->

		<!-- Container -->
		<div class="container">
			<!-- Notifications -->
			@include('notifications')
			<!-- ./ notifications -->

			<!-- Content -->
			@yield('content')
			<!-- ./ content -->
		</div>
		<!-- ./ container -->

		<!-- the following div is needed to make a sticky footer -->
		<div id="push"></div>
		</div>
		<!-- ./wrap -->


	    <div id="footer">
        <div class="container text-right">
          <small>{{{ Lang::get('site.footer_notice') }}}</small>
	      </div>
	    </div>

		<!-- Javascripts
		================================================== -->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('assets/js/site.js')}}"></script>

        @yield('scripts')
	</body>
</html>
