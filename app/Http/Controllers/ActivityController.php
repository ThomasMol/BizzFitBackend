<?php

namespace App\Http\Controllers;

use App\Models\MentalState;
use App\Models\PhysicalActivity;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    use ApiResponser;

    public function getActivitiesWeek(){
        $user_id = Auth::user()->id;
        $lastWeek = Carbon::now('Europe/Amsterdam')->subWeek();

        $mentalStates = MentalState::where('user_id', $user_id)->where('date_time','>=',$lastWeek)->orderBy('date_time','desc')->get()
        ->groupBy(function($date){return Carbon::parse($date->date_time)->format('Y-m-d');});
        $physicalActivities = PhysicalActivity::where('user_id', $user_id)->where('date_time','>=',$lastWeek)->orderBy('date_time','desc')->get()
        ->groupBy(function($date){return Carbon::parse($date->date_time)->format('Y-m-d');});
        return $this->success([$mentalStates, $physicalActivities]);
    }

}
