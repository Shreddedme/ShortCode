<?php

namespace App\Controller;

use App\CodeGenerator\ShortCodeGenerator;
use App\Entity\Link;
use App\Repository\LinkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class LinkController extends AbstractController
{
    public function __construct(
        private readonly LinkRepository $linkRepository,
        private readonly ShortCodeGenerator $codeGenerator,
        private readonly EntityManagerInterface $entityManager
    ){}

    #[Route('/link', name: 'app_link')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/LinkController.php',
        ]);
    }

    #[Route('/link/create')]
    public function create(Request $request ): JsonResponse
    {
        $originalUrl = $request->get('originalUrl');
        $linkEntity = null;
        if (filter_var($originalUrl, FILTER_VALIDATE_URL)) {
            $shortCode = $this->codeGenerator->generate();
            $linkEntity = new Link($originalUrl, $shortCode, 0);
            $this->entityManager->persist($linkEntity);
            $this->entityManager->flush();
        }
        return $this->json($linkEntity?->getId());
    }

    #[Route('/link/list')]
    public function list(): JsonResponse
    {
        return $this->json($this->linkRepository->getAll());
    }

    #[Route('/link/get')]
    public function getByCode(Request $request): JsonResponse
    {
        $code = $request->query->get('code');
        $linkEntity = $this->entityManager->getRepository(Link::class)->find(1);
        var_dump($linkEntity); die();
        return $this->json($linkEntity);
    }

    #[Route('/r')]
    public function codeRedirect(Request $request): RedirectResponse
    {
        $code = $request->query->get('code');
        $linkEntity = $this->linkRepository->getByCode($code);
        $linkEntity['count_transition']++;
        $this->linkRepository->update($linkEntity);
        return $this->redirect($linkEntity['original_url']);
    }

    #[Route('/link/delete')]
    public function delete (Request $request): JsonResponse
    {
        $code = $request->query->get('code');
        $this->linkRepository->delete($code);
        return $this->json([]);
    }
}