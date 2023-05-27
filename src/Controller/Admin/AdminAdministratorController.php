<?php declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/admin/administrator/{page<\d+>}", name="web_admin_administrator", methods={"GET"})
     */
    public function index(int $page = 1): Response
    {
        $enableDeleteButton = ! $this->isLastAdministratorAccount();

        $queryBuilder = $this->userRepository->findAllUsersAsQueryBuilder();

        $pager = new Pagerfanta(
            new QueryAdapter($queryBuilder)
        );

        $pager->setMaxPerPage(10);
        $pager->setCurrentPage($page);

        return $this->render('admin/administrator/index.html.twig', [
            'pager' => $pager,
            'enableDeleteButton' => $enableDeleteButton,
        ]);
    }

    /**
     * @Route("/admin/administrator/{id}/show", name="web_admin_administrator_show", methods={"GET"})
     */
    public function show(Request $request): Response
    {
        $user = $this->userRepository->findOneBy([
            'id' => $request->get('id'),
        ]);
        return $this->render('admin/administrator/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/admin/administrator/{id}", name="web_admin_administrator_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        if ($this->isLastAdministratorAccount()) {
            $this->addFlash('info', 'Non è possibile eliminare l\'account');

            return $this->redirectToRoute('web_admin_administrator', [], Response::HTTP_SEE_OTHER);
        }

        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $userRepository->remove($user, true);
            $this->addFlash('success', 'Account eliminato');
        }

        return $this->redirectToRoute('web_admin_administrator', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * Verifica che ci sia almeno un account amministratore
     */
    private function isLastAdministratorAccount(): bool
    {
        $result = false;
        $administratorAccounts = $this->userRepository->findAll();
        if (1 === \count($administratorAccounts)) {
            $result = true;
        }

        return $result;
    }
}
