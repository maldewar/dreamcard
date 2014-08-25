@extends('layouts.scaffold')

@section('main')

<h1>All Transactions</h1>

<p>{{ link_to_route('transactions.create', 'Add New Transaction', null, array('class' => 'btn btn-lg btn-success')) }}</p>

@if ($transactions->count())
	<table class="table table-striped">
		<thead>
			<tr>
				<th>User_id</th>
				<th>Type</th>
				<th>Mean</th>
				<th>Credit</th>
				<th>Amount</th>
				<th>Target_info</th>
				<th>Target_user_id</th>
				<th>Target_card_id</th>
				<th>&nbsp;</th>
			</tr>
		</thead>

		<tbody>
			@foreach ($transactions as $transaction)
				<tr>
					<td>{{{ $transaction->user_id }}}</td>
					<td>{{{ $transaction->type }}}</td>
					<td>{{{ $transaction->mean }}}</td>
					<td>{{{ $transaction->credit }}}</td>
					<td>{{{ $transaction->amount }}}</td>
					<td>{{{ $transaction->target_info }}}</td>
					<td>{{{ $transaction->target_user_id }}}</td>
					<td>{{{ $transaction->target_card_id }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('transactions.destroy', $transaction->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('transactions.edit', 'Edit', array($transaction->id), array('class' => 'btn btn-info')) }}
                    </td>
				</tr>
			@endforeach
		</tbody>
	</table>
@else
	There are no transactions
@endif

@stop
