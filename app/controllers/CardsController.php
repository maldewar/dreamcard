<?php

class CardsController extends BaseController {

	/**
	 * Card Repository
	 *
	 * @var Card
	 */
	protected $card;

	public function __construct(Card $card)
	{
		$this->card = $card;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$cards = $this->card->all();

		return View::make('cards.index', compact('cards'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('cards.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::all();
		$validation = Validator::make($input, Card::$rules);

		if ($validation->passes())
		{
      $entity = $this->card->create($input);
      Image::upload(Input::file('image'), 'cards/' . $entity->id, 'card.jpg', true);

			return Redirect::route('cards.index');
		}

		return Redirect::route('cards.create')
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
		$card = $this->card->findOrFail($id);

		return View::make('cards.show', compact('card'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$card = $this->card->find($id);

		if (is_null($card))
		{
			return Redirect::route('cards.index');
		}

		return View::make('cards.edit', compact('card'));
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
		$validation = Validator::make($input, Card::$rules);

		if ($validation->passes())
		{
			$card = $this->card->find($id);
      $card->update($input);
      Image::upload(Input::file('image'), 'cards/' . $id, 'card.jpg', true);

			return Redirect::route('cards.show', $id);
		}

		return Redirect::route('cards.edit', $id)
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
		$this->card->find($id)->delete();

		return Redirect::route('cards.index');
	}

}
