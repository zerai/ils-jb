<?php declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdministratorCreateCommand extends Command
{
    protected static $defaultName = 'app:administrator:create';

    protected static $defaultDescription = 'Add a user as administrator';

    private UserPasswordHasherInterface $passwordHasher;

    private UserRepository $userRepository;

    public function __construct(UserPasswordHasherInterface $passwordHasher, UserRepository $userRepository)
    {
        $this->passwordHasher = $passwordHasher;
        $this->userRepository = $userRepository;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::OPTIONAL, 'User email')
            ->addArgument('password', InputArgument::OPTIONAL, 'User password')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email = $this->getEmailArgumentOrError($input, $io);

        $password = $this->getPasswordArgumentOrError($input, $io);

        $adminUser = $this->createAdminUser($email, $password);

        try {
            $this->userRepository->add($adminUser, true);
        } catch (\Exception $exception) {
            $io->error($exception->getMessage());
            return Command::FAILURE;
        }

        $io->success('New Admin user was created.');
        $io->info('User login email: ' . $adminUser->getEmail());

        return Command::SUCCESS;
    }

    private function getEmailArgumentOrError(InputInterface $input, SymfonyStyle $io): string
    {
        $email = (string) $input->getArgument('email');

        if ($email === '') {
            $io->error('Empty mail');
            exit;
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $io->error(sprintf('Invalid email: %s', $email));
            exit;
        }

        return $email;
    }

    private function getPasswordArgumentOrError(InputInterface $input, SymfonyStyle $io): string
    {
        $password = (string) $input->getArgument('password');

        if ($password === '') {
            $io->error('Empty password');
            exit;
        }

        return $password;
    }

    private function createAdminUser(string $email, string $password): User
    {
        $user = new User();
        $user->setEmail($email);
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword(
            $this->passwordHasher->hashPassword(
                $user,
                $password
            )
        );

        return $user;
    }
}
