@extends('site.layouts.default')

@section('title')
Show Card
@parent
@stop

@section('content')

<h1>Show Card</h1>

<p>{{ link_to_route('cards.index', 'Return to All cards', null, array('class'=>'btn btn-primary')) }}</p>

<div class="panel panel-default col-sm-3">
  <div class="panel-body">
    <img src="{{{ $card->getImage() }}}" style="width:100%"/>
  </div>
</div>

<div class="col-sm-9">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Name</th>
          <th>Location</th>
          <th>Active</th>
          <th>Description EN</th>
          <th>Description ES</th>
      </tr>
    </thead>

    <tbody>
      <tr>
        <td>{{{ $card->name }}}</td>
            <td>{{{ $card->getLocation() }}}</td>
            <td>@if($card->active == 1) true @else false @endif</td>
            <td>{{{ $card->desc_en }}}</td>
            <td>{{{ $card->desc_es }}}</td>
                      <td>
                          {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('cards.destroy', $card->id))) }}
                              {{ Form::submit('Delete', array('class' => 'btn btn-default')) }}
                          {{ Form::close() }}
                          {{ link_to_route('cards.edit', 'Edit', array($card->id), array('class' => 'btn btn-primary')) }}
                      </td>
      </tr>
    </tbody>
  </table>
</div>

@stop
