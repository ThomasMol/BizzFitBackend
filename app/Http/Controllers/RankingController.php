<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    use ApiResponser;

    public function getTopTen(){
        $topTen = Organization::orderBy('score', 'desc')->limit(10)->get();
        return $this->success($topTen);
    }

    public function getCurrentRanking($organizationId){
        $ranking = Organization::where('id',$organizationId)->first();
        return $this->success($ranking);
    }

    public function getTopTenOfIndustry($industry){
        $topTen = Organization::where('industry',$industry)->limit(10)->get();
        return $this->success($topTen);
    }

    public function getTopTenOfOrganization($organizationId){
        $topTen = User::where('organization_id',$organizationId)->limit(10)->get();
        return $this->success($topTen);
    }

}
