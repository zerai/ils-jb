<?php declare(strict_types=1);

namespace JobPosting\Adapter\Http\Web;

use JobPosting\Application\Model\JobPost\JobPost;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JobPostController extends AbstractController
{
    /**
     * @Route("/jobpost", name="web_jobpost_index", methods={"GET"})
     */
    public function index(): Response
    {
        $jobposts = $this->getFakeJobPostData();

        return $this->render('jobpost/index.html.twig', [
            'jobposts' => $jobposts,
        ]);
    }

    private function getFakeJobPostData(): array
    {
        # fake data
        $first = new JobPost(Uuid::uuid4(), 'title 1');
        $first->setDescription('description 001');
        $second = new JobPost(Uuid::uuid4(), 'title 2');
        $second->setDescription('description 002');
        $third = new JobPost(Uuid::uuid4(), 'title 3');
        $third->setDescription('description 003');

        return [
            $first,
            $second,
            $third,

        ];
    }
}
