<?php

namespace App\Services;
use App\Models\Job;
use Respect\Validation\Validator as v;

class JobService {
    public function addJob($request, $result) {
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

       array_push($result,
            'getMessage', $getMessage,
            'e', $e,
            'saved', $saved,
            'userId', $userId
        );

        return $result;
    }

    public function deleteJob($id) {
        $job = Job::find($id);
        $job->delete();
    }

    public function restoreJob($id) {
        $job = Job::withTrashed()->find($id);
        $job->restore();
    }

    public function forceDeleteJob($id) {
        $job = Job::withTrashed()->find($id);
        $job->forceDelete();
    }
}