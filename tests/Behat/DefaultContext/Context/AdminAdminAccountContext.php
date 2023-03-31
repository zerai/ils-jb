<?php declare(strict_types=1);

namespace App\Tests\Behat\DefaultContext\Context;

use App\Entity\User;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use function PHPUnit\Framework\assertNotNull;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdminAdminAccountContext extends RawMinkContext implements Context
{
    private KernelInterface $kernel;

    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(KernelInterface $kernel, UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->kernel = $kernel;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    /**
     * @Given sono presenti i seguenti account con ruolo di amministratore
     */
    public function sonoPresentiISeguentiAccountConRuoloDiAmministratore(TableNode $table): void
    {
        $em = $this->kernel->getContainer()->get('doctrine')->getManager();
        $adminAccount = new User();
        foreach ($table as $row) {
            if (! empty($row['email'])) {
                $adminAccount = $this->createAdminAccountWithMail($row['email']);
            }

            $em->persist($adminAccount);
        }

        $em->flush();
        ;
    }

    /**
     * @When clicco :linkText nella riga :rowText
     */
    public function cliccoNellaRiga($linkText, $rowText)
    {
        $row = $this->findRowWithText($rowText);

        $row->clickLink($linkText);
    }

    private function findRowWithText($rowText, $tableSelector = 'table')
    {
        $row = $this->getSession()->getPage()->find(
            'css',
            sprintf(
                '%s tr:contains("%s")',
                trim($tableSelector),
                $rowText
            )
        );

        assertNotNull($row, 'Failed to find row with text: ' . $rowText);

        return $row;
    }

    /**
     * @When premo :buttonText nella riga :rowText
     */
    public function premoNellaRiga($buttonText, $rowText): void
    {
        $row = $this->findRowWithText($rowText);

        $row->pressButton($buttonText);
    }

    private function createAdminAccountWithMail($string): User
    {
        $admin = new User();
        $admin->setEmail($string);
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->userPasswordHasher->hashPassword($admin, 'irrelevant'));

        return $admin;
    }
}
