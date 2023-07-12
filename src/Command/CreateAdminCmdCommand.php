<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Regex;

#[AsCommand(
    name: 'CreateAdminCmd',
    description: 'Création d\'un utilisateur avec droits "ADMIN"',
)]
class CreateAdminCmdCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $validator = Validation::createValidator();
        $constraintsTel = new Regex(['pattern' => '/^(\+33|0)[0-9]{9}$/']);
        $constraintsMail = new Email();


        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }
        $io->title('Création du profil Administrateur');
        $nom = $io->ask('Nom','admin');
        do {
            $is_mailOK = true;
            $email = $io->ask('Email');
            $violations = $validator->validate($email, $constraintsMail);
            if (0 !== count($violations)) {
                $io->caution('Format d\'email incorrect !');
                $is_mailOK =  false;
            }
        } while (($is_mailOK == false) || (empty($email)));

        do {
            $is_telOK = true;
            $tel = $io->ask('Téléphone (sans espace)');
            $violations = $validator->validate($tel, $constraintsTel);
            if (0 !== count($violations)) {
                $io->caution('Le N° est incorrect !');
                $is_telOK =  false;
            }
        } while (($is_telOK == false) || (empty($tel)));

        do {
            $is_pwdConfirmed = true;
            do {
                $is_pwdNotNull = true;
                $password1 = $io->askHidden('Mot de passe');
                if (empty($password1)) {
                    $io->caution('Le mot de passe ne peut pas être vide !');
                    $is_pwdNotNull = false;
                }
            } while ($is_pwdNotNull == false);
                    
            do {
                $password2 = $io->askHidden('Confirmation du mot de passe');
            } while (empty($password2));

            if ($password1 !== $password2) {
                $io->caution('Les mots de passe ne sont pas identiques.');
                $is_pwdConfirmed = false;
            }
        } while ($is_pwdConfirmed === false);

        $user = new User();
        $user->setNom($nom);
        $user->setEmail($email);
        $user->setTel($tel);
        $user->setPassword($password1);
        $user->setNbConvive(0);
        $user->setRoles(["ROLE_ADMIN","ROLE_USER"]);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    
        $io->success('L\'administrateur %s a été créé dans la base.');
        $io->listing([
            sprintf('Nom : %s',$nom),
            sprintf('Email : %s',$email),
            sprintf('Tél. : %s',$tel),
        ]);

        return Command::SUCCESS;
    }
}
