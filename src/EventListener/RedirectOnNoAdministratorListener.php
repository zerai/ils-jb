<?php declare(strict_types=1);

namespace App\EventListener;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;

class RedirectOnNoAdministratorListener implements EventSubscriberInterface
{
    private RouterInterface $router;

    private EntityManagerInterface $doctrine;

    public function __construct(RouterInterface $router, EntityManagerInterface $doctrine)
    {
        $this->router = $router;
        $this->doctrine = $doctrine;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (! $event->isMainRequest()) {
            return;
        }
        $firstTimeUrl = $this->router->generate('web_installer_administrator');
        $currentUrl = $event->getRequest()->getRequestUri();

        // previene infinite redirect loop
        if ($currentUrl === $firstTimeUrl) {
            return;
        }

        if ($this->isThereAtLeastOneAdminUser()) {
            return;
        }

        $event->setResponse(new RedirectResponse($firstTimeUrl));
    }

    public function isThereAtLeastOneAdminUser(): bool
    {
        $result = false;
        $total = $this->doctrine->getRepository(User::class)->count([]);
        if ($total > 0) {
            $result = true;
        }

        return $result;
    }
}
