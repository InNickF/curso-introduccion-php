<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\User;
use Zend\Diactoros\Response\RedirectResponse;

class AuthController extends BaseController {
    public function getLogin() {
        $userId = $_SESSION['userId'] ?? null;
        $routeProtectedMessage = $_SESSION['routeProtected'] ?? null;
        if($userId) {
            return new RedirectResponse('/admin');
        }
        
            return $this->renderHTML('login.twig', [
                'routeProtectedMessage' => $routeProtectedMessage,
            ]);
    }

    public function postLogin($request) {
        $postData = $request->getParsedBody();
        $user = User::where('email', $postData['email'])->first();
        $error = null;
        $errorMessage = null;

        if($user) {
            if (\password_verify($postData['password'], $user->password)) {
                $_SESSION['userId'] = $user->id;
                unset($_SESSION['routeProtected']);
                return new RedirectResponse('/admin');
            } else {
                $error = true;
                $errorMessage = 'El usuario o la contraseña no es correto.';
                return $this->renderHTML('login.twig', [
                    'errorMessage' => $errorMessage,
                    'error' => $error,
                ]);
            }
        } else {
            $error = true;
            $errorMessage = 'El usuario o la contraseña no es correto.';
            return $this->renderHTML('login.twig', [
                'errorMessage' => $errorMessage,
                'error' => $error,
            ]);
        };

    }
    public function getLogout() {
        unset($_SESSION['userId']);
        return new RedirectResponse('/login');
    }
}