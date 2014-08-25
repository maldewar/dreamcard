@extends('layouts.scaffold')

@section('main')

<h1>Show CardInstance</h1>

<p>{{ link_to_route('cardInstances.index', 'Return to All cardInstances', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

<table class="table table-striped">
	<thead>
		<tr>
			<th>From_user_id</th>
				<th>Amount</th>
				<th>Currency</th>
				<th>To_user_id</th>
				<th>To_user_email</th>
				<th>Card_id</th>
				<th>Status</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $cardInstance->from_user_id }}}</td>
					<td>{{{ $cardInstance->amount }}}</td>
					<td>{{{ $cardInstance->currency }}}</td>
					<td>{{{ $cardInstance->to_user_id }}}</td>
					<td>{{{ $cardInstance->to_user_email }}}</td>
					<td>{{{ $cardInstance->card_id }}}</td>
					<td>{{{ $cardInstance->status }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('cardInstances.destroy', $cardInstance->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('cardInstances.edit', 'Edit', array($cardInstance->id), array('class' => 'btn btn-info')) }}
                    </td>
		</tr>
	</tbody>
</table>

@stop
