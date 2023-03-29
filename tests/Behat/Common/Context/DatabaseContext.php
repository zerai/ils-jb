<?php declare(strict_types=1);

namespace App\Tests\Behat\Common\Context;

use Behat\Behat\Context\Context;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * This context class contains the definitions of the steps used by the default
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class DatabaseContext implements Context
{
    private KernelInterface $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * TODO: FIX 'Suite hook callback: App\Tests\Behat\Common\Context\DatabaseContext::clearAllData() must be a static method '
     * #@BeforeSuite
     */
    public function clearAllData(): void
    {
        $em = $this->kernel->getContainer()->get('doctrine')->getManager();
        $purger = new ORMPurger($em);
        $purger->purge();
    }
}
