<?php declare(strict_types=1);

namespace App\Tests\Behat\DefaultContext\Context;

use Behat\Behat\Context\Context;
use function PHPUnit\Framework\assertStringContainsString;
use Symfony\Component\HttpKernel\KernelInterface;

require_once __DIR__ . '/../../../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

class ConsoleCommandProcessorContext implements Context
{
    private KernelInterface $kernel;

    private ?string $output = null;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @When I run :command
     */
    public function iRun($command)
    {
        $this->output = shell_exec($command);
    }

    /**
     * @Then I should see :string in the output
     */
    public function iShouldSeeInTheOutput($string)
    {
        assertStringContainsString(
            $string,
            $this->output,
            sprintf('Did not see "%s" in output "%s"', $string, $this->output)
        );
    }

    /**
     * @Given There are no administrator account in the system
     */
    public function thereAreNoAdministratorAccountInTheSystem()
    {
        $em = $this->kernel->getContainer()->get('doctrine')->getManager();

        $em->createQuery('DELETE FROM App:User')->execute();
    }
}
