@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Create CardInstance</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::open(array('route' => 'cardInstances.store', 'class' => 'form-horizontal')) }}

        <div class="form-group">
            {{ Form::label('from_user_id', 'From_user_id:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'from_user_id', Input::old('from_user_id'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('amount', 'Amount:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('amount', Input::old('amount'), array('class'=>'form-control', 'placeholder'=>'Amount')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('currency', 'Currency:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('currency', Input::old('currency'), array('class'=>'form-control', 'placeholder'=>'Currency')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('to_user_id', 'To_user_id:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'to_user_id', Input::old('to_user_id'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('to_user_email', 'To_user_email:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('to_user_email', Input::old('to_user_email'), array('class'=>'form-control', 'placeholder'=>'To_user_email')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('card_id', 'Card_id:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'card_id', Input::old('card_id'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('status', 'Status:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('status', Input::old('status'), array('class'=>'form-control', 'placeholder'=>'Status')) }}
            </div>
        </div>


<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit('Create', array('class' => 'btn btn-lg btn-primary')) }}
    </div>
</div>

{{ Form::close() }}

@stop


