<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use Respect\Validation\Validator as v;

class UsersController extends BaseController {
    public function getAddUserAction($request) {
        $e = null;
        $saved = null;
        $getMessage = null;
        $errorReporting = null;

        $postData = $request->getParsedBody();
        $userValidator = v::key('name', v::stringType()->notEmpty()->notOptional())
            ->key('email', v::email()->notEmpty()->notOptional())
            ->key('password', v::notEmpty()->notOptional()->length(6, 22));

        if ($request->getMethod() == 'POST') {

            try {
                $userValidator->assert($postData);
                $user = new User();
                $user->name = $postData['name'];
                $user->email = $postData['email'];
                $user->password = password_hash($postData['password'], PASSWORD_DEFAULT);
                
                $user->save();
                $saved = true;
                $getMessage = 'Se ha creado correctamente el User.';
            } catch (\Exception $e) {
                $errorReporting = $e->getMessage();
                $getMessage = 'Ha ocurrido un error al tratar de crear el User:';
            }
        };

        return $this->renderHTML('addUser.twig', [
            'error' => $e,
            'getMessage' => $getMessage,
            'saved' => $saved,
            'errorReporting' => $errorReporting,
        ]);
    }
}
