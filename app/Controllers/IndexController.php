<?php

namespace App\Controllers;

use App\Models\{Job, Project};
use App\Controllers\BaseController;

class IndexController extends BaseController {
    public function indexAction()
    {
        $strings = 'Nick';
        $lastName = 'Fuenmayor';
        $fullName = "$strings David $lastName Molinares";
        $userId = $_SESSION['userId'] ?? null;
        $totalMonths = 0;
        $limitMonths = 120;
        $jobs = Job::All();

        $projects = Project::all();

        return $this->renderHTML('index.twig', [
            'fullname' => $fullName,
            'jobs' => $jobs,
            'projects' => $projects,
            'userId' => $userId,
        ]);
    }
};
