<?php

namespace Saadzer\LaravelJobChain;

use Imtigger\LaravelJobStatus\Trackable;
use Illuminate\Foundation\Bus\DispatchesJobs;

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
    protected function runChild($jobToRun , $queue = "default"){
        $chainEntity = app(config("laraveljobchain.model"));
        dispatch($jobToRun)->onQueue($queue);
        $chainEntity->create([
            "parent_id" => $this->getJobStatusId(),
            "child_id" => $jobToRun->getJobStatusId()
        ]);
        return $jobToRun ;
    }
}
