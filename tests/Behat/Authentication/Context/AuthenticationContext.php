<?php declare(strict_types=1);

namespace App\Tests\Behat\Authentication\Context;

use App\Entity\User;
use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthenticationContext extends MinkContext implements Context
{
    private KernelInterface $kernel;

    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(KernelInterface $kernel, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->kernel = $kernel;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /**
     * @BeforeScenario
     */
    public function clearData(): void
    {
        $em = $this->kernel->getContainer()->get('doctrine')->getManager();

        $em->createQuery('DELETE FROM App:User')->execute();
    }

    /**
     * @Given il sistema è correttamente inizializzato con almeno un amministratore
     */
    public function ilSistemaECorrettamenteInizializzatoConAlmenoUnAmministratore()
    {
        $this->createRandomAdministrator();
    }

    private function createRandomAdministrator(): User
    {
        $randomAdmin = new User();
        $randomAdmin->setEmail(Uuid::uuid4() . '@example.com');
        $randomAdmin->setRoles(['ROLE_ADMIN']);
        $randomAdmin->setPassword($this->userPasswordHasher->hashPassword($randomAdmin, 'irrelevant'));

        $em = $this->kernel->getContainer()->get('doctrine')->getManager();
        $em->persist($randomAdmin);
        $em->flush();

        return $randomAdmin;
    }

    /**
     * @Given un account amministratore con email :email e password :password
     */
    public function unAccountAmministratoreConEmailEPassword($email, $password)
    {
        $adminUser = new User();
        $adminUser->setEmail($email);
        $adminUser->setRoles(['ROLE_ADMIN']);
        $adminUser->setPassword($this->userPasswordHasher->hashPassword($adminUser, $password));

        $em = $this->kernel->getContainer()->get('doctrine')->getManager();
        $em->persist($adminUser);
        $em->flush();
    }

    /**
     * @Given sono autenticato con privilegi di amministratore
     */
    public function sonoAutenticatoConPrivilegiDiAmministratore()
    {
        $randomEmail = Uuid::uuid4() . '@example.com';
        $defaultTestPassword = 'default_test_password';
        $this->unAccountAmministratoreConEmailEPassword($randomEmail, $defaultTestPassword);
        $this->visitPath('/login');
        $this->fillField('username', $randomEmail);
        $this->fillField('password', $defaultTestPassword);

        $this->pressButton('login');
    }
}
