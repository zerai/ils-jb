<?php declare(strict_types=1);

namespace JobPosting\Adapter\Http\Web;

use JobPosting\Adapter\Persistence\Doctrine\MySqlJobPostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobPostController extends AbstractController
{
    private MySqlJobPostRepository $jobPostRepository;

    public function __construct(MySqlJobPostRepository $jobPostRepository)
    {
        $this->jobPostRepository = $jobPostRepository;
    }

    /**
     * @Route("/lavoro", name="web_jobpost_index", methods={"GET"})
     */
    public function index(): Response
    {
        $jobposts = $this->jobPostRepository->findPublishedJobPost();

        return $this->render('jobpost/index.html.twig', [
            'jobposts' => $jobposts,
        ]);
    }
}
