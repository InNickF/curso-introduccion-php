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
        $userId = $_SESSION['userId'] ?? null;

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
            'userId' => $userId,
        ]);
    }

    public function getPassword(){
        return $this->renderHTML('users/pass.twig');
    }

public function changePassword($request){
        $responseMessage = '';
        $classMessage = '';
        if($request->getMethod() == "POST"){
            $postData = $request->getParsedBody();

            $dataValidation = v::key('password',v::stringType()->notEmpty())
                                       ->key('newpass',v::stringType()->notEmpty())
                                       ->key('confirmpass',v::stringType()->notEmpty());
            try {
                $dataValidation->assert($postData);
                $sessionUserId = $_SESSION['userId'] ?? null;
                $userSearch = User::find($sessionUserId);
                if($userSearch){
                    if(password_verify($postData['password'],$userSearch->password)){
                        if($postData['newpass']==$postData['confirmpass']){
                            $newPass = password_hash($postData['newpass'],PASSWORD_DEFAULT);
                            $userSearch->password = $newPass;
                            $userSearch->save();
                            $responseMessage = 'saved';
                            $classMessage = 'success';
                        } else{
                            $responseMessage = 'Confirm Pass';
                            $classMessage = 'warning';
                        }
                    } else{
                        $responseMessage = 'Check credentials';
                        $classMessage = 'warning';
                    }
                } else{
                    $responseMessage = 'User not Found';
                    $classMessage = 'error';
                }
            }catch (\Exception $e){
                $responseMessage = $e->getMessage();
                $classMessage = 'warning';
            }

        }
        return $this->renderHTML('users/pass.twig',[
           'responseMessage' => $responseMessage,
           'classMessage' => $classMessage
        ]);
    }
}
