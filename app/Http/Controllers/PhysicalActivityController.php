<?php

namespace App\Http\Controllers;

use App\Models\PhysicalActivity;
use App\Models\User;
use App\Traits\ApiResponser;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PhysicalActivityController extends Controller
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
        $physicalActivities = PhysicalActivity::where('user_id', $user_id)->orderBy('date_time','desc')->limit(25)->get();
        return $this->success($physicalActivities);
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
            'type' => 'required|string|max:255',
            'time' => 'required|numeric|max:99999',
            'date_time' => 'required|date',
            'fitness_api_id' => 'string'
        ]);
        // TODO Calculate points
        $faker = Factory::create();
        $points = $faker->numberBetween(25,85);
        $user_id = Auth::user()->id;
        $user = User::where('id',$user_id)->first();
        $user->score = $user->score + $points;
        $user->save();

        $physicalActivity = PhysicalActivity::create([
            'id' => (string) Str::uuid(),
            'user_id' => Auth::user()->id,
            'type' => $attr['type'],
            'points' => $points,
            'time_seconds' => $attr['time'],
            'date_time' => $attr['date_time'],
            'fitness_api_id' => $attr['fitness_api_id'],
        ]);

        return $this->success([
            'physical_activity_id' => $physicalActivity->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PhysicalActivity  $physicalActivity
     * @return \Illuminate\Http\Response
     */
    public function show(PhysicalActivity $physicalActivity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PhysicalActivity  $physicalActivity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PhysicalActivity $physicalActivity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PhysicalActivity  $physicalActivity
     * @return \Illuminate\Http\Response
     */
    public function destroy(PhysicalActivity $physicalActivity)
    {
        //
    }
}
