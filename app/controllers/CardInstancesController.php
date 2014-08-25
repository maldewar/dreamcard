<?php

class CardInstancesController extends BaseController {

	/**
	 * CardInstance Repository
	 *
	 * @var CardInstance
	 */
	protected $cardInstance;

	public function __construct(CardInstance $cardInstance)
	{
		$this->cardInstance = $cardInstance;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$cardInstances = $this->cardInstance->all();

		return View::make('cardInstances.index', compact('cardInstances'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('cardInstances.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, CardInstance::$rules);

		if ($validation->passes())
		{
			$this->cardInstance->create($input);

			return Redirect::route('cardInstances.index');
		}

		return Redirect::route('cardInstances.create')
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
		$cardInstance = $this->cardInstance->findOrFail($id);

		return View::make('cardInstances.show', compact('cardInstance'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$cardInstance = $this->cardInstance->find($id);

		if (is_null($cardInstance))
		{
			return Redirect::route('cardInstances.index');
		}

		return View::make('cardInstances.edit', compact('cardInstance'));
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
		$validation = Validator::make($input, CardInstance::$rules);

		if ($validation->passes())
		{
			$cardInstance = $this->cardInstance->find($id);
			$cardInstance->update($input);

			return Redirect::route('cardInstances.show', $id);
		}

		return Redirect::route('cardInstances.edit', $id)
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
		$this->cardInstance->find($id)->delete();

		return Redirect::route('cardInstances.index');
	}

}
