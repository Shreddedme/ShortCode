<?php

namespace App\Controller;

use App\CodeGenerator\ShortCodeGenerator;
use App\Repository\FileLinkRepository;
use App\Repository\LinkRepository;
use App\Repository\SessionLinkRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class LinkController extends AbstractController
{
    public function __construct(
        private readonly FileLinkRepository $linkRepository,
        private readonly ShortCodeGenerator $codeGenerator,
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
    public function create(Request $request): JsonResponse
    {
        $originalUrl = $request->get('originalUrl');
        $linkEntity = null;
        if (filter_var($originalUrl, FILTER_VALIDATE_URL)) {
            $shortCode = $this->codeGenerator->generate();
            $linkEntity = [
                'originalURL' => $originalUrl,
                'shortCode' => $shortCode,
                'countTransition' => 0,
            ];

            $this->linkRepository->save($linkEntity);
        }
        return $this->json($linkEntity);
    }

    #[Route('/link/clear')]
    public function clear(): JsonResponse
    {
        $this->linkRepository->clear();
        return $this->json([]);
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
        $linkEntity = $this->linkRepository->getByCode($code);
        return $this->json($linkEntity);
    }

    #[Route('/r')]
    public function codeRedirect(Request $request): RedirectResponse
    {
        $code = $request->query->get('code');
        $linkEntity = $this->linkRepository->getByCode($code);
        return $this->redirect($linkEntity['originalURL']);

    }
}
