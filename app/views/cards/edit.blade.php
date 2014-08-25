@extends('site.layouts.default')

@section('title')
Edit Card
@parent
@stop

@section('content')

{{ Form::model($card, array('class' => 'form-horizontal', 'method' => 'PATCH', 'files' => true, 'route' => array('cards.update', $card->id))) }}

        <div class="form-group">
            {{ Form::label('name', 'Name:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::text('name', Input::old('name'), array('class'=>'form-control', 'placeholder'=>'Name')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('location', 'Location:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::select('location', array('0' => 'Mexico and USA', '1' => 'Mexico', '2' => 'United States'), Input::old('location'), array('class'=>'form-control')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('active', 'Active:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::checkbox('active', Input::old('active', true), true, array('class'=>'form-control', 'placeholder'=>'Active')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('desc_en', 'Desc_en:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::textarea('desc_en', Input::old('desc_en'), array('class'=>'form-control', 'placeholder'=>'Desc_en')) }}
            </div>
        </div>

        <div class="form-group">
            {{ Form::label('desc_es', 'Desc_es:', array('class'=>'col-md-2 control-label')) }}
            <div class="col-sm-10">
              {{ Form::textarea('desc_es', Input::old('desc_es'), array('class'=>'form-control', 'placeholder'=>'Desc_es')) }}
            </div>
        </div>

        <div class="form-group">
          {{ Form::label('image', 'Image:', array('class'=>'col-md-2 control-label')) }}
          <div class="col-sm-10">
            <span class="btn btn-default btn-file">
              Browse <input type="file" name="image">
            </span>
          </div>
        </div>


<div class="form-group">
    <label class="col-sm-2 control-label">&nbsp;</label>
    <div class="col-sm-10">
      {{ Form::submit('Update', array('class' => 'btn btn-primary')) }}
      {{ link_to_route('cards.show', 'Cancel', $card->id, array('class' => 'btn btn-default')) }}
    </div>
</div>

{{ Form::close() }}

@stop
