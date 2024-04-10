<?php declare(strict_types=1);

namespace JobPosting\Tests\Behat\JobPost\Context;

use App\Tests\Behat\Bootstrap\AdminDictionaryTrait;
use App\Tests\Behat\Bootstrap\WebsiteAreaDictionaryTrait;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\RawMinkContext;
use JobPosting\Application\Model\JobPost\JobPost;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpKernel\KernelInterface;
use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertNotNull;

class JobPostContext extends RawMinkContext implements Context
{
    use AdminDictionaryTrait;
    use WebsiteAreaDictionaryTrait;

    private KernelInterface $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @BeforeScenario
     */
    public function clearJobPostData(): void
    {
        $em = $this->kernel->getContainer()->get('doctrine')->getManager();

        $em->createQuery('DELETE FROM JobPosting:JobPost\\JobPost')->execute();
    }

    /**
     * @Given ci sono :count offerte di lavoro
     */
    public function ciSonoOfferteDiLavoro($count)
    {
        $em = $this->kernel->getContainer()->get('doctrine')->getManager();
        for ($i = 0; $i < $count; $i++) {
            $jobpost = new JobPost(Uuid::uuid4(), 'title');
            $jobpost->setDescription('lorem ipsum');

            $em->persist($jobpost);
        }

        $em->flush();
    }

    /**
     * @Then dovrei vedere :count offerte di lavoro
     */
    public function dovreiVedereOfferteDiLavoro($count)
    {
        $table = $this->getSession()->getPage()->find('css', 'table.table');
        assertNotNull($table, 'Could not find a table');
        assertCount((int) $count, $table->findAll('css', 'tbody tr'));
    }

    /**
     * @Given sono presenti le seguenti offerte di lavoro
     */
    public function sonoPresentiLeSeguentiOfferteDiLavoro(TableNode $table)
    {
        $em = $this->kernel->getContainer()->get('doctrine')->getManager();

        foreach ($table as $row) {
            $jobpost = $this->createRandomJobPost();
            if (! empty($row['titolo'])) {
                $jobpost->setTitle($row['titolo']);
            }
            if (! empty($row['descrizione'])) {
                $jobpost->setDescription($row['descrizione']);
            }
            if (! empty($row['inizio pubblicazione'])) {
                $jobpost->setPublicationStart(\DateTimeImmutable::createFromFormat('Y-m-d|', $row['inizio pubblicazione']));
            }
            if (! empty($row['fine pubblicazione'])) {
                $jobpost->setPublicationEnd(\DateTimeImmutable::createFromFormat('Y-m-d|', $row['fine pubblicazione']));
            }

            if (! empty($row['pubblicato']) && $row['pubblicato'] === 'si') {
                $jobpost->setPublicationStart(new \DateTimeImmutable('yesterday'));
                $jobpost->setPublicationEnd(new \DateTimeImmutable('tomorrow'));
            }
            if (! empty($row['pubblicato']) && $row['pubblicato'] === 'no') {
                $jobpost->setPublicationStart(new \DateTimeImmutable('tomorrow'));
                $jobpost->setPublicationEnd(new \DateTimeImmutable('+ 2 days'));
            }

            $em->persist($jobpost);
        }

        $em->flush();
    }

    /**
     * @When clicco :linkText nella riga :rowText
     */
    public function cliccoNellaRiga($linkText, $rowText)
    {
        $row = $this->findRowWithText($rowText);

        $link = $row->clickLink($linkText);
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

    private function createRandomJobPost(): JobPost
    {
        $randomJobpost = new JobPost(Uuid::uuid4(), 'irrelevant');
        $randomJobpost->setDescription('irrelevant');

        return $randomJobpost;
    }
}
