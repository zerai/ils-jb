<?php declare(strict_types=1);

namespace JobPosting\Adapter\Http\Web;

use JobPosting\Adapter\Persistence\Doctrine\MySqlJobPostRepository;
use JobPosting\Application\Model\JobPost\JobPost;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("admin/jobpost/new", name="web_admin_jobpost_new", methods={"GET", "POST"})
     */
    public function create(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $jobpost = new JobPost(Uuid::uuid4(), $request->get('title'));
            $jobpost->setDescription($request->get('description'));

            $this->jobPostRepository->add($jobpost, true);

            $this->addFlash('success', 'Nuova offerta di lavoro creata');

            return $this->redirectToRoute('web_admin_jobpost_index');
        }

        return $this->render('admin/jobpost/new.html.twig');
    }

    /**
     * @Route("admin/jobpost/delete/{id}", name="web_admin_jobpost_delete")
     */
    public function delete(Request $request): Response
    {
        $jobPost = $this->jobPostRepository->findOneBy([
            'id' => $request->get('id'),
        ]);

        $this->jobPostRepository->remove($jobPost, true);

        $this->addFlash('success', 'Offerta di lavoro eliminata');

        return $this->redirectToRoute('web_admin_jobpost_index');
    }
}
