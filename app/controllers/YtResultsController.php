<?php

class YtResultsController extends BaseController {

	/**
	 * YtResult Repository
	 *
	 * @var YtResult
	 */
	protected $ytResult;

	public function __construct(YtResult $ytResult)
	{
		$this->ytResult = $ytResult;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$ytResults = $this->ytResult->all();

		return View::make('ytResults.index', compact('ytResults'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('ytResults.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, YtResult::$rules);

		if ($validation->passes())
		{
			$this->ytResult->create($input);

			return Redirect::route('ytResults.index');
		}

		return Redirect::route('ytResults.create')
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$ytResult = $this->ytResult->findOrFail($id);

		return View::make('ytResults.show', compact('ytResult'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$ytResult = $this->ytResult->find($id);

		if (is_null($ytResult))
		{
			return Redirect::route('ytResults.index');
		}

		return View::make('ytResults.edit', compact('ytResult'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$input = array_except(Input::all(), '_method');
		$validation = Validator::make($input, YtResult::$rules);

		if ($validation->passes())
		{
			$ytResult = $this->ytResult->find($id);
			$ytResult->update($input);

			return Redirect::route('ytResults.show', $id);
		}

		return Redirect::route('ytResults.edit', $id)
			->withInput()
			->withErrors($validation)
			->with('message', 'There were validation errors.');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$this->ytResult->find($id)->delete();

		return Redirect::route('ytResults.index');
	}

}
