<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:grant-role')]
class GrantRoleCommand extends Command
{
    private UserRepository $userRepo;
    private EntityManagerInterface $emi;

    public function __construct(
        UserRepository $userRepo,
        EntityManagerInterface $emi
    ) {
        $this->userRepo = $userRepo;
        $this->emi = $emi;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            // the command description shown when running "php bin/console list"
            ->setDescription('Gives a specified role to a user')
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to give a user a role specified during execution')
            ->addArgument('role', InputArgument::REQUIRED, 'Role to grant user')
            ->addArgument('email', InputArgument::REQUIRED, 'User email')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userRepo->findOneBy(['email' => $input->getArgument('email')]);

        if (!($user instanceof User)) {
            $output->writeln("Role can't be assigned, user not found");

            return Command::FAILURE;
        }

        $user->addRole("ROLE_" . $input->getArgument('role'));

        $this->emi->persist($user);
        $this->emi->flush();

        $output->writeln('Role has been granted to user');
        return Command::SUCCESS;
    }
}
