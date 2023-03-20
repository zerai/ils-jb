<?php declare(strict_types=1);

namespace JobPosting\Adapter\Http\Web;

use JobPosting\Adapter\Persistence\Doctrine\MySqlJobPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminJobPostController extends AbstractController
{
    private MySqlJobPostRepository $jobPostRepository;

    public function __construct(MySqlJobPostRepository $jobPostRepository)
    {
        $this->jobPostRepository = $jobPostRepository;
    }

    /**
     * @Route("/admin/jobpost", name="web_admin_jobpost_index", methods={"GET"})
     */
    public function index(): Response
    {
        $jobposts = $this->jobPostRepository->findAll();

        return $this->render('admin/jobpost/index.html.twig', [
            'jobposts' => $jobposts,
        ]);
    }
}
