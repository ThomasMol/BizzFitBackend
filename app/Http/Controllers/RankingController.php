<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RankingController extends Controller
{
    use ApiResponser;

    // Get global top ten organizations
    public function getTopTen(){
        $topTen = Organization::orderBy('score', 'desc')->limit(10)->get();
        return $this->success($topTen);
    }

    // Get top ten users of current user's organization
    public function getTopTenOfOrganization(){
        $organizationId = Auth::user()->organization_id;
        $topTen = User::where('organization_id',$organizationId)->orderBy('score', 'desc')->limit(10)->get();
        return $this->success($topTen);
    }

    // Get rank number of current user in organization
    public function getMyRanking(){
       $users = User::where('organization_id',Auth::user()->organization_id)->orderBy('score', 'desc')->get();
       $user = $users->where('id', Auth::user()->id);
       $rank = $user->keys()->first() + 1;
       return $this->success($rank);
    }

    // Get organization rank number of organization of current user
    public function getMyOrganizationRanking(){
       $organizations = Organization::orderBy('score', 'desc')->get();
       $organization = $organizations->where('id', Auth::user()->organization_id);
       $rank = $organization->keys()->first() + 1;
       return $this->success($rank);
    }

    // Not yet used, might only be necessary for admins
    public function getCurrentRanking($organizationId){
        $ranking = Organization::where('id',$organizationId)->first();
        return $this->success($ranking);
    }

    // Maybe only useful for managers
    public function getTopTenOfIndustry($industry){
        $topTen = Organization::where('industry',$industry)->limit(10)->get();
        return $this->success($topTen);
    }

}
