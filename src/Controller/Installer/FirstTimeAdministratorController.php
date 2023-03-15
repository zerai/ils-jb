<?php declare(strict_types=1);

namespace App\Controller\Installer;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstTimeAdministratorController extends AbstractController
{
    /**
     * @Route("/installer/administrator", name="web_installer_administrator")
     */
    public function index(): Response
    {
        return $this->render('installer/first_time_administrator/index.html.twig', [
        ]);
    }
}
