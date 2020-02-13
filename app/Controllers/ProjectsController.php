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
        
        $postData = $request->getParsedBody();
        $projectValidator = v::key('title', v::stringType()->notEmpty())
            ->key('description', v::stringType()->notEmpty());
        
        if ($request->getMethod() == 'POST') {

            try {
                $projectValidator->assert($postData);
                $project = new Project();
                $project->title = $postData['title'];
                $project->description = $postData['description'];
                $project->save();
                $saved = true;
                $getMessage = 'Se ha creado correctamente el Project.';
                
            } catch (\Exception $e) {
                $getMessage = 'Ha ocurrido un error al tratar de crear el Project, corrige tu formulario y vuelve a intentar.';
            }
        };

        return $this->renderHTML('addProject.twig', [
            'error' => $e,
            'getMessage' => $getMessage,
            'saved' => $saved,
        ]);
        // include_once '../views/addJob.php';
    }
}
