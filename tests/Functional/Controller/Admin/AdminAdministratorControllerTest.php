<?php declare(strict_types=1);

namespace App\Tests\Functional\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Http\Authenticator\Token\PostAuthenticationToken;

class AdminAdministratorControllerTest extends WebTestCase
{
    private const DEFAULT_ADMINISTRATOR_EMAIL = 'test-admin@example.com';

    private KernelBrowser $client;

    private UserRepository $repository;

    private string $path = '/admin/administrator/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(User::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }

        $this->setUpDefaultAdminUser();
    }

    public function testIndex(): void
    {
        $this->logInAsAdmin();
        $this->client->followRedirects(true);
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Gestione amministratori');

        $this->assertSelectorTextContains('table', self::DEFAULT_ADMINISTRATOR_EMAIL);

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testShow(): void
    {
        $this->logInAsAdmin();
        $this->client->followRedirects(true);
        $fixture = new User();
        $fixture->setEmail('other-admin@example.com');
        $fixture->setRoles(['ROLE_ADMIN']);
        $fixture->setPassword('123456');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/show', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Account amministratore');
        self::assertStringContainsString('other-admin@example.com', $this->client->getResponse()->getContent());

        // Use assertions to check that the properties are properly displayed.
    }

    public function testHideDeleteButtonWhenLastAdminAccount(): void
    {
        $this->logInAsAdmin();
        $this->client->followRedirects(true);

        $defaultAdminUser = $this->repository->findOneBy([
            'email' => self::DEFAULT_ADMINISTRATOR_EMAIL,
        ]);

        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);

        self::assertStringContainsString(self::DEFAULT_ADMINISTRATOR_EMAIL, $this->client->getResponse()->getContent());

        self::assertSelectorTextNotContains('table > tbody > tr', 'elimina');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testDenyDeleteActionWhenLastAdminAccount(): void
    {
        self::markTestIncomplete('config. javascript test.');
        $this->logInAsAdmin();
        $this->client->followRedirects(true);
    }

    protected function logInAsAdmin(): void
    {
        $defaultAdminUser = $this->repository->findOneBy([
            'email' => self::DEFAULT_ADMINISTRATOR_EMAIL,
        ]);

        if (null === $defaultAdminUser) {
            $this->setUpDefaultAdminUser();
        }

        $session = $this->client->getContainer()->get('session');

        $firewallName = 'main';
        // if you don't define multiple connected firewalls, the context defaults to the firewall name
        // See https://symfony.com/doc/current/reference/configuration/security.html#firewall-context
        $firewallContext = 'main';

        // you may need to use a different token class depending on your application.
        // for example, when using Guard authentication you must instantiate PostAuthenticationGuardToken

        //$token = new UsernamePasswordToken('admin@example.com', null, $firewallName, ['ROLE_ADMIN']);

        $token = new PostAuthenticationToken($defaultAdminUser, 'main', $defaultAdminUser->getRoles());

        $session->set('_security_' . $firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }

    private function setUpDefaultAdminUser(): void
    {
        $defaultAdminUser = new User();
        $defaultAdminUser->setEmail(self::DEFAULT_ADMINISTRATOR_EMAIL);
        $defaultAdminUser->setRoles(['ROLE_ADMIN']);
        $defaultAdminUser->setPassword('irrelevant');

        $this->repository->add($defaultAdminUser, true);
    }
}
