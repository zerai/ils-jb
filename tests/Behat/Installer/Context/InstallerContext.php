<?php declare(strict_types=1);

namespace App\Tests\Behat\Installer\Context;

use App\Tests\Behat\Bootstrap\WebsiteAreaDictionaryTrait;
use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * This context class contains the definitions of the steps used by the installer
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 *
 * @see http://behat.org/en/latest/quick_start.html
 */
final class InstallerContext extends RawMinkContext implements Context
{
    use WebsiteAreaDictionaryTrait;

    private KernelInterface $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * Resetta il sistema eliminando
     * tutti i dati nel database
     *
     * ESEMPIO: Dato il sistema non è inizializzato correttamente
     * ESEMPIO: E il sistema non è inizializzato correttamente
     *
     * @Given /^il sistema non è inizializzato correttamente$/
     */
    public function ilSistemaNonEInizializzatoCorrettamente()
    {
        $this->clearAllDatabaseData();
    }

    /**
     * Verifica che la pagina corrente sia quella
     * di installazione
     *
     * Esempio: Allora dovrei essere sulla pagina di installazione
     * Esempio: E dovrei essere sulla pagina di installazione
     *
     * @Then /^dovrei essere sulla pagina di installazione$/
     */
    public function dovreiEssereSullaPaginaDiInstallazione()
    {
        $this->assertSession()->addressEquals($this->locatePath('/installer/administrator'));
    }

    private function clearAllDatabaseData(): void
    {
        $em = $this->kernel->getContainer()->get('doctrine')->getManager();
        $purger = new ORMPurger($em);
        $purger->purge();
    }
}
