<?php

namespace App\Controller;

use App\Repository\LinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class LinkController extends AbstractController
{
    public function __construct(
        private readonly LinkRepository $linkRepository
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
    public function create(): JsonResponse
    {
        $linkEntity = [
            'originalURL' => '',
            'shortCode' => '',
            'countTransition' => 0
        ];
        $this->linkRepository->save($linkEntity);
        return $this->json($linkEntity);
    }

    #[Route('/link/list')]
    public function list(): JsonResponse
    {
        return $this->json($this->linkRepository->getByCode(''));
    }
}
