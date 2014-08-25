@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Edit Transaction</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::model($transaction, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('transactions.update', $transaction->id))) }}

        <div class="form-group">
            {{ Form::label('user_id', 'User_id:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'user_id', Input::old('user_id'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('type', 'Type:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('type', Input::old('type'), array('class'=>'form-control', 'placeholder'=>'Type')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('mean', 'Mean:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('mean', Input::old('mean'), array('class'=>'form-control', 'placeholder'=>'Mean')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('credit', 'Credit:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('credit', Input::old('credit'), array('class'=>'form-control', 'placeholder'=>'Credit')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('amount', 'Amount:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('amount', Input::old('amount'), array('class'=>'form-control', 'placeholder'=>'Amount')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('target_info', 'Target_info:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('target_info', Input::old('target_info'), array('class'=>'form-control', 'placeholder'=>'Target_info')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('target_user_id', 'Target_user_id:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'target_user_id', Input::old('target_user_id'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('target_card_id', 'Target_card_id:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'target_card_id', Input::old('target_card_id'), array('class'=>'form-control')) }}
            </div>
        </div>


<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit('Update', array('class' => 'btn btn-lg btn-primary')) }}
      {{ link_to_route('transactions.show', 'Cancel', $transaction->id, array('class' => 'btn btn-lg btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop