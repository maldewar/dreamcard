@extends('layouts.scaffold')

@section('main')

<h1>Show YtResult</h1>

<p>{{ link_to_route('ytResults.index', 'Return to All ytResults', null, array('class'=>'btn btn-lg btn-primary')) }}</p>

<table class="table table-striped">
	<thead>
		<tr>
			<th>Video_id</th>
				<th>Url</th>
				<th>Title</th>
				<th>Username</th>
				<th>User_id</th>
				<th>User_url</th>
				<th>Views</th>
				<th>Published_at</th>
				<th>Thumb</th>
		</tr>
	</thead>

	<tbody>
		<tr>
			<td>{{{ $ytResult->video_id }}}</td>
					<td>{{{ $ytResult->url }}}</td>
					<td>{{{ $ytResult->title }}}</td>
					<td>{{{ $ytResult->username }}}</td>
					<td>{{{ $ytResult->user_id }}}</td>
					<td>{{{ $ytResult->user_url }}}</td>
					<td>{{{ $ytResult->views }}}</td>
					<td>{{{ $ytResult->published_at }}}</td>
					<td>{{{ $ytResult->thumb }}}</td>
                    <td>
                        {{ Form::open(array('style' => 'display: inline-block;', 'method' => 'DELETE', 'route' => array('ytResults.destroy', $ytResult->id))) }}
                            {{ Form::submit('Delete', array('class' => 'btn btn-danger')) }}
                        {{ Form::close() }}
                        {{ link_to_route('ytResults.edit', 'Edit', array($ytResult->id), array('class' => 'btn btn-info')) }}
                    </td>
		</tr>
	</tbody>
</table>

@stop
