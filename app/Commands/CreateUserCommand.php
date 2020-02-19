<?php
namespace App\Commands;

use App\Models\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;



class CreateUserCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:create-user';

    protected function configure()
    {
        $this
        // the short description shown while running "php bin/console list"
        ->setDescription('Creates a new user.')

        // the full command description shown when running the command with
        // the "--help" option
        ->setHelp('This command allows you to create a user...');
        
        $this
        // configure an argument
        ->addArgument('username', InputArgument::REQUIRED, 'The username of the user.')
        ->addArgument('email', InputArgument::REQUIRED, 'The email of the user.')
        ->addArgument('password',InputArgument::REQUIRED, 'User password');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);
            
        $user = new User();
        $user->name = $input->getArgument('username');
        $user->email = $input->getArgument('email');
        $user->password = password_hash($input->getArgument('password'), PASSWORD_DEFAULT);
        $user->save();
        
        // retrieve the argument value using getArgument()
        $output->writeln('Username: '.$input->getArgument('username'));
    
        return 0;
    }
}