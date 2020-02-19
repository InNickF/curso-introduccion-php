<?php
namespace App\Controllers;

require_once '../vendor/autoload.php';

use App\Models\ContactForm;
use Exception;
use Laminas\Diactoros\ServerRequest;
use Respect\Validation\Validator as v;

use Laminas\Diactoros\Response\RedirectResponse;
use Respect\Validation\Exceptions\ValidationException;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;



class ContactController extends BaseController {
    public function getIndex() {
        return $this->renderHTML('/contact/index.twig');
    }

    public function postSendForm(ServerRequest $request) {
        $e = null;
        $sended = null;
        $getMessage = null;

        $requestData = $request->getParsedBody();
        $userName = $requestData['name'];
        $userEmail = $requestData['email'];
        $userMessage = $requestData['message'];

        $userValidator = v::key('name', v::stringType()->notEmpty()->notOptional())
            ->key('email', v::email()->notEmpty()->notOptional())
            ->key('message', v::notEmpty()->notOptional());
        
        try {
            $userValidator->assert($requestData);
            
            $contactForm = new ContactForm();
            $contactForm->name = $userName;
            $contactForm->email = $userEmail;
            $contactForm->message = $userMessage;
            $contactForm->sended = false;
            $contactForm->save();
            $sended = true;
            $getMessage = 'Sended';
        } catch(Exception $e) {
            $getMessage = 'Error at send email, try again';
        }

        return $this->renderHTML('/contact/index.twig', [
            'error' => $e,
            'sended' => $sended,
            'getMessage' => $getMessage
        ]);
        
    }
}