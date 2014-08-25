@extends('site.layouts.default')

@section('title')
All Cards
@parent
@stop

@section('content')

<h1>All Cards</h1>

<p>{{ link_to_route('cards.create', 'Add New Card', null, array('class' => 'btn btn-primary')) }}</p>

@if ($cards->count())
	<table class="table table-striped">
		<thead>
      <tr>
        <th>ID</th>
        <th>&nbsp;</th>
				<th>Name</th>
				<th>Location</th>
				<th>Active</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($cards as $card)
        <tr>
          <td>{{{ $card->id }}}</td>
          <td><img src="{{{ $card->getSmallThumb() }}}"/></td>
					<td>{{{ $card->name }}}</td>
					<td>{{{ $card->getLocation() }}}</td>
					<td>@if($card->active == 1) true @else false @endif</td>
          <td>
              {{ link_to_route('cards.show', 'Show', array($card->id), array('class' => 'btn btn-primary')) }}
              {{ link_to_route('cards.edit', 'Edit', array($card->id), array('class' => 'btn btn-primary')) }}
              {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('cards.destroy', $card->id))) }}
                  {{ Form::submit('Delete', array('class' => 'btn btn-default')) }}
              {{ Form::close() }}
          </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no cards.
@endif

@stop
