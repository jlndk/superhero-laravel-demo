<?php

namespace App\Http\Controllers;

use App\Superhero;
use Illuminate\Http\Request;

class SuperheroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Superhero::all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Superhero  $superhero
     * @return \Illuminate\Http\Response
     */
    public function show(Superhero $superhero)
    {
        return $superhero;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|string|max:200',
            'alter_ego' => 'required|string|max:200',
            'first_appeared' => 'required|numeric|between:1000, 4000',
        ]);

        return Superhero::create($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Superhero  $superhero
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Superhero $superhero)
    {
        $data = $this->validate($request, [
            'name' => 'string|max:200',
            'alter_ego' => 'string|max:200',
            'first_appeared' => 'numeric|between:1000, 4000',
        ]);

        $superhero->update($data);

        return $superhero;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Superhero  $superhero
     * @return \Illuminate\Http\Response
     */
    public function destroy(Superhero $superhero)
    {
        $superhero->delete();

        return response()->json([
            'status' => 'deleted'
        ], 200);
    }
}
