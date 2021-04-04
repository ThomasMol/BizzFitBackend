<?php

namespace App\Http\Controllers;

use App\Models\MentalState;
use App\Models\PhysicalActivity;
use App\Traits\ApiResponser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InsightsController extends Controller
{
    use ApiResponser;

    public function getMentalStateInsights(){
        $lastMonth = Carbon::now('Europe/Amsterdam')->subMonth();
        $lastWeek = Carbon::now('Europe/Amsterdam')->subWeek();
        $today = Carbon::now('Europe/Amsterdam')->subDay();

        $organization_id = Auth::user()->organization_id;

        // Get mental state stats
        $mentalStates = MentalState::leftJoin('users','mental_states.user_id','users.id')
        ->where('users.organization_id', $organization_id)
        ->where('mental_states.date_time','>=', $lastMonth)
        ->select('mental_states.state', 'mental_states.date_time', 'mental_states.points')->get();

        $averageMentalMonth = $mentalStates->avg('state');
        $averageMentalWeek = $mentalStates->where('date_time','>=',$lastWeek)->avg('state');
        $averageMentalToday = $mentalStates->where('date_time','>=',$today)->avg('state');

        // Get physical activity stats
        $mentalStates = PhysicalActivity::leftJoin('users','physical_activities.user_id','users.id')
        ->where('users.organization_id', $organization_id)
        ->where('physical_activities.date_time','>=', $lastMonth)
        ->select('physical_activities.date_time', 'physical_activities.points')->get();

        $averagePhysicalMonth = $mentalStates->avg('points');
        $averagePhysicalWeek = $mentalStates->where('date_time','>=',$lastWeek)->avg('points');
        $averagePhysicalToday = $mentalStates->where('date_time','>=',$today)->avg('points');

        return $this->success([
            'average_mental_month' => round($averageMentalMonth, 1),
            'average_mental_week' => round($averageMentalWeek, 1),
            'average_mental_today' => round($averageMentalToday, 1),
            'average_physical_month' => round($averagePhysicalMonth, 1),
            'average_physical_week' => round($averagePhysicalWeek, 1),
            'average_physical_today' => round($averagePhysicalToday, 1),
        ]);
    }
}

