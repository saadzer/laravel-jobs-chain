<?php

namespace Saadzer\LaravelJobChain;

use Imtigger\LaravelJobStatus\JobStatus;

class JobChain extends JobStatus
{

    protected $table="job_chains" ;

    public function parents()
    {
        return $this->belongsToMany(app(config("laraveljobchain.model")), 'job_chains', 'child_id', 'parent_id');
    }

    public function children()
    {
        return $this->belongsToMany(app(config("laraveljobchain.model")), 'job_chains', 'parent_id', 'child_id');
    }

    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    public function root()
    {
        $cur = $this;
        while ($cur->parent) {
            $cur = $cur->parent;
        }
        return $cur;
    }
}
