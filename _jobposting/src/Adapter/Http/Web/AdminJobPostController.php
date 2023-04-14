<?php declare(strict_types=1);

namespace JobPosting\Adapter\Http\Web;

use JobPosting\Adapter\Http\Web\Form\Dto\JobPostDto;
use JobPosting\Adapter\Http\Web\Form\JobPostType;
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
     * @Route("/admin", name="web_admin_index", methods={"GET"})
     */
    public function list(): Response
    {
        $jobPosts = $this->jobPostRepository->findAll();

        return $this->render('@jobposting/admin/jobpost/index.html.twig', [
            'jobposts' => $jobPosts,
        ]);
    }

    /**
     * @Route("admin/jobpost/new", name="web_admin_jobpost_new", methods={"GET", "POST"})
     */
    public function new(Request $request): Response
    {
        $jobPostFormModel = new JobPostDto();
        $form = $this->createForm(JobpostType::class, $jobPostFormModel, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var JobPostDto $formData */
            $formData = $form->getData();

            $jobPost = new JobPost(Uuid::uuid4(), $formData->title);
            $jobPost->setDescription($formData->description);

            if (null !== $formData->publicationStart) {
                $jobPost->setPublicationStart($formData->publicationStart);
            }

            if (null !== $formData->publicationEnd) {
                $jobPost->setPublicationEnd($formData->publicationEnd);
            }

            $this->jobPostRepository->add($jobPost, true);

            $this->addFlash('success', 'Nuova offerta di lavoro creata');

            return $this->redirectToRoute('web_admin_jobpost_index');
        }

        return $this->renderForm('@jobposting/admin/jobpost/new.html.twig', [
            'form' => $form,
        ]);
    }

    /**
     * @Route("admin/jobpost/{id}", name="web_admin_jobpost_show", methods={"GET"})
     */
    public function show(Request $request): Response
    {
        $jobPost = $this->jobPostRepository->findOneBy([
            'id' => $request->get('id'),
        ]);

        return $this->render('@jobposting/admin/jobpost/show.html.twig', [
            'jobpost' => $jobPost,
        ]);
    }

    /**
     * @Route("admin/jobpost/edit/{id}", name="web_admin_jobpost_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request): Response
    {
        // find jobPost or
        $jobPost = $this->jobPostRepository->findOneBy([
            'id' => $request->get('id'),
        ]);

        $formModel = $this->mapJobpostToFormModel($jobPost);
        $form = $this->createForm(JobpostType::class, $formModel, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var JobPostDto $formData */
            $formData = $form->getData();
            $jobPost->setTitle($formData->title);
            $jobPost->setDescription($formData->description);

            $this->jobPostRepository->add($jobPost, true);

            $this->addFlash('success', 'Offerta di lavoro modificata');

            return $this->redirectToRoute('web_admin_jobpost_show', [
                'id' => $jobPost->getId(),
            ]);
        }

        return $this->renderForm('@jobposting/admin/jobpost/edit.html.twig', [
            'form' => $form,
        ]);
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

    private function mapJobpostToFormModel(JobPost $jobPost): JobPostDto
    {
        $formModel = new JobPostDto();
        $formModel->title = $jobPost->getTitle();
        $formModel->description = $jobPost->getDescription();
        $formModel->publicationStart = $jobPost->getPublicationStart();
        $formModel->publicationEnd = $jobPost->getPublicationEnd();

        return $formModel;
    }
}
