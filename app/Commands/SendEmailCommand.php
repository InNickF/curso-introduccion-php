<?php
namespace App\Commands;

use App\Models\ContactForm;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SendEmailCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:send-email';

    protected function configure()
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Send email when an user fill the contact form.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This is a Async task thas send an email from the db conta form that flag send is false...');       
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $pendingMessage = ContactForm::where('sended', false)->first();

        if($pendingMessage) {

        // // Create the Transport
        $transport = (new Swift_SmtpTransport(getenv('MAIL_HOST'), getenv('MAIL_PORT')))
        ->setUsername(getenv('MAIL_USERNAME'))
        ->setPassword(getenv('MAIL_PASSWORD'))
        ;
        
        // // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);
        
        // // Create a message
        $message = (new Swift_Message('Contact Form'))
        ->setFrom([getenv('MAIL_FROM_ADDRESS') => getenv('MAIL_FROM_NAME')])
        ->setTo(['in.nickf@gmail.com' => 'Nick'])
        ->setBody("Hi, you have a new messsage of: $pendingMessage->name | $pendingMessage->email, and ther message is: $pendingMessage->message");
        // Send the message
        $result = $mailer->send($message);
        
        $pendingMessage->sended = true;
        $pendingMessage->save();


        $output->writeln([
            'Send Email',
            '============',
            "User: $pendingMessage->name",
            "email: $pendingMessage->email",
            "Message: $pendingMessage->message",]);
        } else {
        $output->writeln('There no pending message');
        }
            
        return 0;
    }
}