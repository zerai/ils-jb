<?php declare(strict_types=1);

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminAdministratorController extends AbstractController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/admin/administrator", name="web_admin_administrator")
     */
    public function index(): Response
    {
        $users = $this->userRepository->findAll();

        return $this->render('admin/administrator/index.html.twig', [
            'users' => $users,
        ]);
    }
}
