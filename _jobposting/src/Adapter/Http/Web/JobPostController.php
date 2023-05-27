<?php declare(strict_types=1);

namespace JobPosting\Adapter\Http\Web;

use JobPosting\Adapter\Persistence\Doctrine\MySqlJobPostRepository;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    public function index(Request $request): Response
    {
        $queryBuilder = $this->jobPostRepository->findPublishedJobPostAsQueryBuilder();

        $pager = new Pagerfanta(
            new QueryAdapter($queryBuilder)
        );

        $pager->setMaxPerPage(10);
        $pager->setCurrentPage((int) $request->query->get('page', '1'));

        return $this->render('jobpost/index.html.twig', [
            'pager' => $pager,
        ]);
    }
}
