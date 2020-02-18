<?php

namespace App\Controllers;

use App\Models\Job;
use App\Controllers\BaseController;
use App\Services\JobService;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\ServerRequest;

class JobsController extends BaseController {
    private $jobService;

    public function __construct(JobService $jobService) {
        parent::__construct();
        $this->jobService = new $jobService;
    }
    
    public function indexAction() {
        $jobs = Job::withTrashed()->get();

        return $this->renderHTML('jobs/index.twig', compact('jobs'));
    }

    public function deleteAction(ServerRequest $request) {
        $params = $request->getQueryParams();
        $jobId = $params['id'];
        $this->jobService->deleteJob($jobId);

        return new RedirectResponse('/jobs');
    }

    public function restoreAction(ServerRequest $request) {
        $params = $request->getQueryParams();
        $jobId = $params['id'];
        $this->jobService->restoreJob($jobId);

        return new RedirectResponse('/jobs');
    }

    public function forceDeleteAction(ServerRequest $request) {
        $params = $request->getQueryParams();
        $jobId = $params['id'];
        $this->jobService->forceDeleteJob($jobId);

        return new RedirectResponse('/jobs');
    }

    public function getAddJobAction($request) {
        $result = ['getMessage' => null,
        'e' => null,
        'saved' => null,
        'userId' => null];

        $finalResult = $this->jobService->addJob($request, $result);
        // var_dump($finalResult);
        return $this->renderHTML('addJob.twig', [
            'getMessage' => $finalResult['getMessage'],
            'error' => $finalResult['e'],
            'saved' => $finalResult['saved'],
            'userId' => $finalResult['userId'],
            ]);
    }
}
