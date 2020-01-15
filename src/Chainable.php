<?php

namespace Saadzer\LaravelJobChain;

use Imtigger\LaravelJobStatus\Trackable;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Str;

trait Chainable
{
    use Trackable, DispatchesJobs;

    protected $parents ;
    protected $children;

    protected function getParents(){
        $chainEntity = app(config("laraveljobchain.model"));
        $this->parents  = $chainEntity->query()->where('child_id' , $this->id)  ;
    }
    protected function getChildren(){
        $chainEntity = app(config("laraveljobchain.model"));
        $this->parents  = $chainEntity->query()->where('parent_id' , $this->id)  ;
    }
    protected function runChild($jobToRun , $chainId = ""  ,  $queue = "default"){
        if(!$chainId){
            $chainId =Str::uuid();
        }
        $chainEntity = app(config("laraveljobchain.model"));
        dispatch($jobToRun)->onQueue($queue);
        $chainEntity->create([
            "parent_id" => $this->getJobStatusId(),
            "child_id" => $jobToRun->getJobStatusId(),
            "chain_id" => $chainId
        ]);
        return $jobToRun ;
    }
    protected function addChildToChain($jobToAdd ,$chainId ){
        $chainEntity = app(config("laraveljobchain.model"));
        $chainEntity->create([
            "parent_id" => $this->root->getJobStatusId() , 
            "child_id" => $jobToAdd->getJobStatusId(),
            "chain_id" => $chainId
        ]);
    }
}
