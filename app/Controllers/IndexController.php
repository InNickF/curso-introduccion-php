<?php

namespace App\Controllers;

use App\Models\{Job, Project};
use App\Controllers\BaseController;

class IndexController extends BaseController {
    public function indexAction()
    {   
        $userName = $_SESSION['userName'] ?? null;
        $strings = 'Nick';
        $lastName = 'Fuenmayor';
        $fullName = "$strings David $lastName Molinares";
        $userId = $_SESSION['userId'] ?? null;

        
        $jobs = Job::All();

        $arrayJobs = [];
        foreach ($jobs as $job) {
            array_push($arrayJobs, [
                'id' => $job->id,
                'title' => $job->title,
                'description' => $job->description,
                'months' => $job->months,
                'logo' => $job->logo,
                'getImage' => $job->getImage($job['title'], $job['logo'])

            ]);
        };

        $projects = Project::all();
        
        $limitMonths = 10;
        $filterJobs = function(array $job) use($limitMonths) {
            return $job['months'] >= $limitMonths;
        };

        $jobs = array_filter($arrayJobs, $filterJobs);

        return $this->renderHTML('index.twig', [
            'fullname' => $fullName,
            'jobs' => $jobs,
            'projects' => $projects,
            'userId' => $userId,
            'userName' => $userName,
        ]);
    }
};
