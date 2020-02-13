<?php

namespace App\Controllers;

use App\Models\Job;
use App\Controllers\BaseController;
use Respect\Validation\Validator as v;

class JobsController extends BaseController {
    public function getAddJobAction($request) {
        $getMessage = null;
        $e = null;
        $saved = null;
        if ($request->getMethod() == 'POST') {
            $postData = $request->getParsedBody();
            $jobValidator = v::key('title', v::stringType()->notEmpty())
                ->key('description', v::stringType()->notEmpty());

            try {
                $jobValidator->assert($postData);
                $job = new Job();
                $job->title = $postData['title'];
                $job->description = $postData['description'];
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
            ]);
    }
}
