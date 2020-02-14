<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Project;
use Respect\Validation\Validator as v;

class ProjectsController extends BaseController {
    public function getAddProjectAction($request) {
        $e = null;
        $saved = null;
        $getMessage = null;
        $errorReporting = null;
        $userId = $_SESSION['userId'] ?? null;
        
        $postData = $request->getParsedBody();
        $projectValidator = v::key('title', v::stringType()->notEmpty())
            ->key('description', v::stringType()->notEmpty());
        
        if ($request->getMethod() == 'POST') {

            try {
                $projectValidator->assert($postData);
                $files = $request->getUploadedFiles();
                $logo = $files['logo'];
                $project = new Project();
                $project->title = $postData['title'];
                $project->description = $postData['description'];
                if($logo->getError() == UPLOAD_ERR_OK) {
                    $fileName = $logo->getClientFileName();
                    $logoSrc = "uploads/$fileName";
                    $logo->moveTo($logoSrc);
                    $project->logo = $logoSrc;
                }
                $project->save();
                $saved = true;
                $getMessage = 'Se ha creado correctamente el Project.';
                
            } catch (\Exception $e) {
                $errorReporting = $e->getMessage();
                $getMessage = 'Ha ocurrido un error al tratar de crear el Project:';
            }
        };

        return $this->renderHTML('addProject.twig', [
            'error' => $e,
            'getMessage' => $getMessage,
            'saved' => $saved,
            'errorReporting' => $errorReporting,
            'userId' => $userId,
        ]);
        // include_once '../views/addJob.php';
    }
}
