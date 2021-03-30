<?php

namespace App\Http\Controllers;

use App\Models\PhysicalActivity;
use App\Traits\ApiResponser;
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
        $physicalActivities = PhysicalActivity::where('user_id', $user_id)->orderBy('date_time','desc')->get();
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
            'time' => 'required|numeric|max:255',
            'date_time' => 'required|date'
        ]);

        // TODO Calculate points
        $points = 0;

        $physicalActivity = PhysicalActivity::create([
            'id' => (string) Str::uuid(),
            'user_id' => Auth::user()->id,
            'type' => $attr['type'],
            'points' => $points,
            'time_seconds' => $attr['time'],
            'date_time' => $attr['date_time'],
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
