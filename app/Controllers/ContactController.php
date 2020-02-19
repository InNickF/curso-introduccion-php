<?php
namespace App\Controllers;

require_once '../vendor/autoload.php';

use Exception;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\ServerRequest;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;



class ContactController extends BaseController {
    public function getIndex() {
        return $this->renderHTML('/contact/index.twig');
    }

    public function postSendForm(ServerRequest $request) {
        $requestData = $request->getParsedBody();
        $userName = $requestData['name'];
        $userEmail = $requestData['email'];
        $userMessage = $requestData['message'];
        
        $e = null;
        $sended = null;
        $getMessage = null;

        try {
            // Create the Transport
            $transport = (new Swift_SmtpTransport(getenv('MAIL_HOST'), getenv('MAIL_PORT')))
            ->setUsername(getenv('MAIL_USERNAME'))
            ->setPassword(getenv('MAIL_PASSWORD'))
            ;
    
            // Create the Mailer using your created Transport
            $mailer = new Swift_Mailer($transport);
    
            // Create a message
            $message = (new Swift_Message('Contact Form'))
            ->setFrom([getenv('MAIL_FROM_ADDRESS') => getenv('MAIL_FROM_NAME')])
            ->setTo(['in.nickf@gmail.com' => 'Nick'])
            ->setBody("Hi, you have a new messsage of: $userName - $userEmail and ther message is: $userMessage");
            $sended = true;
            $getMessage = 'Sended';
            // Send the message
            $result = $mailer->send($message);
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