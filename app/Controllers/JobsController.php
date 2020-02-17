<?php

namespace App\Controllers;

use App\Models\Job;
use App\Controllers\BaseController;
use Respect\Validation\Validator as v;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Diactoros\ServerRequest;

class JobsController extends BaseController {
    
    public function indexAction() {
        $jobs = Job::withTrashed()->get();

        return $this->renderHTML('jobs/index.twig', compact('jobs'));
    }

    public function deleteAction(ServerRequest $request) {
        $params = $request->getQueryParams();
        $jobId = $params['id'];
        $job = Job::find($jobId);
        $job->delete();
        return new RedirectResponse('/jobs');
    }

    public function restoreAction(ServerRequest $request) {
        $params = $request->getQueryParams();
        $jobId = $params['id'];
        $job = Job::withTrashed()->find($jobId);
        $job->restore();
        return new RedirectResponse('/jobs');
    }

    public function getAddJobAction($request) {
        $getMessage = null;
        $e = null;
        $saved = null;
        $userId = $_SESSION['userId'] ?? null;
        if ($request->getMethod() == 'POST') {
            $postData = $request->getParsedBody();
            $jobValidator = v::key('title', v::stringType()->notEmpty())
                ->key('description', v::stringType()->notEmpty());

            try {
                $jobValidator->assert($postData);
                $job = new Job();
                $job->title = $postData['title'];
                $job->description = $postData['description'];
                $job->months = $postData['months'];
                $files = $request->getUploadedFiles();
                $logo = $files['logo'];
                if($logo->getError() == UPLOAD_ERR_OK) {
                    $fileName = $logo->getClientFileName();
                    $logoSrc = "uploads/$fileName";
                    $logo->moveTo($logoSrc);
                    $job->logo = $logoSrc;
                }
                $job->save();
                $saved = true;
                $getMessage = 'Se creó correctamente el nuevo Job.';
            } catch (\Exception $e) {
                $getMessage = 'Ha ocurrido un error al enviar el formulario.';
            };
        };

        return $this->renderHTML('addJob.twig', [
            'getMessage' => $getMessage,
            'error' => $e,
            'saved' => $saved,
            'userId' => $userId,
            ]);
    }
}
