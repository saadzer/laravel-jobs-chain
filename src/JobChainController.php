<?php

namespace Saadzer\LaravelJobChain;

use Illuminate\Routing\Controller as BaseController;
use Saadzer\LaravelJobChain\JobChain;

class JobChainController extends BaseController
{


    function index(){
        $jobs = JobChain::with("allChildren")->has('parents' , '=' , 0 )->get() ;
        // return response()->json($jobs) ;
        return view('jobchain::jobchain' , ['jobs' => $jobs]);
    }

}
