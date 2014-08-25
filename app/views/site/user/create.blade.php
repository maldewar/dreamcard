@extends('site.layouts.default')

{{-- Web site Title --}}
@section('title')
{{{ Lang::get('user/user.register') }}} ::
@parent
@stop

{{-- Content --}}
@section('content')
<div class="page-header">
	<h1>{{{ Lang::get('user/user.signup') }}}</h1>
</div>
{{-- Confide::makeSignupForm()->render() --}}
<form method="POST" action="{{{ URL::to('users') }}}" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{{ Session::getToken() }}}">
    <fieldset>
        <div class="form-group">
            <label for="email">{{{ Lang::get('confide::confide.e_mail') }}} <!--small>{{{ Lang::get('confide::confide.signup.confirmation') }}}</small--></label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.e_mail') }}}" type="text" name="email" id="email" value="@if($email){{{$email}}}@else{{{ Input::old('email') }}}@endif">
        </div>
        <div class="form-group">
            <label for="username">{{{ Lang::get('confide::confide.username') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.username') }}}" type="text" name="username" id="username" value="{{{ Input::old('username') }}}">
        </div>
        <div class="form-group">
            <label for="first_name">{{{ Lang::get('user/user.first_name') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('user/user.first_name') }}}" type="text" name="first_name" id="first_name" value="{{{ Input::old('first_name') }}}">
        </div>
        <div class="form-group">
            <label for="last_name">{{{ Lang::get('user/user.last_name') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('user/user.last_name') }}}" type="text" name="last_name" id="last_name" value="{{{ Input::old('last_name') }}}">
        </div>
        <div class="form-group">
            <label for="location">{{{ Lang::get('user/user.location') }}}</label>
            <select class="form-control" name="location" id="location">
              <option value="1" @if(Input::old('location') == '1') selected @endif>{{{ Lang::get('site.MX') }}}</option>
              <option value="2" @if(Input::old('location') == '2') selected @endif>{{{ Lang::get('site.US') }}}</option>
            </select>
        </div>
        <div class="form-group">
            <label for="password">{{{ Lang::get('confide::confide.password') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password') }}}" type="password" name="password" id="password">
        </div>
        <div class="form-group">
            <label for="password_confirmation">{{{ Lang::get('confide::confide.password_confirmation') }}}</label>
            <input class="form-control" placeholder="{{{ Lang::get('confide::confide.password_confirmation') }}}" type="password" name="password_confirmation" id="password_confirmation">
        </div>
{{--
        @if (Session::get('error'))
            <div class="alert alert-error alert-danger">
                @if (is_array(Session::get('error')))
                    {{ head(Session::get('error')) }}
                @endif
            </div>
        @endif

        @if (Session::get('notice'))
            <div class="alert">{{ Session::get('notice') }}</div>
        @endif
--}}

        <div class="form-actions form-group">
          <button type="submit" class="btn btn-primary">{{{ Lang::get('confide::confide.signup.submit') }}}</button>
        </div>

    </fieldset>
</form>
@stop
