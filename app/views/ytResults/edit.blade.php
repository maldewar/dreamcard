@extends('layouts.scaffold')

@section('main')

<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <h1>Edit YtResult</h1>

        @if ($errors->any())
        	<div class="alert alert-danger">
        	    <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
        	</div>
        @endif
    </div>
</div>

{{ Form::model($ytResult, array('class' => 'form-horizontal', 'method' => 'PATCH', 'route' => array('ytResults.update', $ytResult->id))) }}

        <div class="form-group">
            {{ Form::label('video_id', 'Video_id:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('video_id', Input::old('video_id'), array('class'=>'form-control', 'placeholder'=>'Video_id')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('url', 'Url:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('url', Input::old('url'), array('class'=>'form-control', 'placeholder'=>'Url')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('title', 'Title:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('title', Input::old('title'), array('class'=>'form-control', 'placeholder'=>'Title')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('username', 'Username:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('username', Input::old('username'), array('class'=>'form-control', 'placeholder'=>'Username')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('user_id', 'User_id:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('user_id', Input::old('user_id'), array('class'=>'form-control', 'placeholder'=>'User_id')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('user_url', 'User_url:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('user_url', Input::old('user_url'), array('class'=>'form-control', 'placeholder'=>'User_url')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('views', 'Views:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::input('number', 'views', Input::old('views'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('published_at', 'Published_at:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('published_at', Input::old('published_at'), array('class'=>'form-control', 'placeholder'=>'Published_at')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('thumb', 'Thumb:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('thumb', Input::old('thumb'), array('class'=>'form-control', 'placeholder'=>'Thumb')) }}
            </div>
        </div>


<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit('Update', array('class' => 'btn btn-lg btn-primary')) }}
      {{ link_to_route('ytResults.show', 'Cancel', $ytResult->id, array('class' => 'btn btn-lg btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop