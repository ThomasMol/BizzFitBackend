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

    // TODO refactor this to separate functions, too much functionality for one method now
    public function getInsights(){
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

        $groupedToday = MentalState::leftJoin('users','mental_states.user_id','users.id')
        ->where('users.organization_id', $organization_id)
        ->select('mental_states.state', 'mental_states.date_time', 'mental_states.points')
        ->where('date_time','>=',$today)->orderBy('state','asc')->select('state', DB::raw('count(*) as total'))->groupBy('state')->get();
        $groupedWeek = MentalState::leftJoin('users','mental_states.user_id','users.id')
        ->where('users.organization_id', $organization_id)
        ->select('mental_states.state', 'mental_states.date_time', 'mental_states.points')
        ->where('date_time','>=',$lastWeek)->orderBy('state','asc')->select('state', DB::raw('count(*) as total'))->groupBy('state')->get();
        $groupedMonth = MentalState::leftJoin('users','mental_states.user_id','users.id')
        ->where('users.organization_id', $organization_id)
        ->select('mental_states.state', 'mental_states.date_time', 'mental_states.points')
        ->where('date_time','>=',$lastMonth)->orderBy('state','asc')->select('state', DB::raw('count(*) as total'))->groupBy('state')->get();

        // Get physical activity stats
        $mentalStates = PhysicalActivity::leftJoin('users','physical_activities.user_id','users.id')
        ->where('users.organization_id', $organization_id)
        ->where('physical_activities.date_time','>=', $lastMonth)
        ->select('physical_activities.date_time', 'physical_activities.points')->get();

        $averagePhysicalMonth = $mentalStates->avg('points');
        $averagePhysicalWeek = $mentalStates->where('date_time','>=',$lastWeek)->avg('points');
        $averagePhysicalToday = $mentalStates->where('date_time','>=',$today)->avg('points');

        return $this->success([
            'average_mental_month' => round($averageMentalMonth),
            'average_mental_week' => round($averageMentalWeek),
            'average_mental_today' => round($averageMentalToday),
            'average_physical_month' => round($averagePhysicalMonth),
            'average_physical_week' => round($averagePhysicalWeek),
            'average_physical_today' => round($averagePhysicalToday),
            'grouped_month' => $groupedMonth,
            'grouped_week' => $groupedWeek,
            'grouped_today' => $groupedToday,
        ]);
    }
}

