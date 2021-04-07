<?php

namespace App\Http\Controllers;

use App\Models\MentalState;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MentalStateController extends Controller
{

    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $mentalStates = MentalState::where('user_id', $user_id)->orderBy('date_time','desc')->get();
        return $this->success($mentalStates);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attr = $request->validate([
            'state' => 'required|numeric|max:255',
            'date_time' => 'required|date'
        ]);

        // TODO Calculate points
        $points = 0;

        $mentalState = MentalState::create([
            'id' => (string) Str::uuid(),
            'user_id' => Auth::user()->id,
            'points' => $points,
            'state' => $attr['state'],
            'date_time' => $attr['date_time'],
        ]);

        return $this->success([
            'mental_state_id' => $mentalState->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MentalState  $mentalState
     * @return \Illuminate\Http\Response
     */
    public function show(MentalState $mentalState)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MentalState  $mentalState
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MentalState $mentalState)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MentalState  $mentalState
     * @return \Illuminate\Http\Response
     */
    public function destroy(MentalState $mentalState)
    {
        //
    }
}
