<?php

namespace App\Controller;

use App\CodeGenerator\ShortCodeGenerator;
use App\Entity\Link;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LinkController extends WrapperAbstractController
{
    public function __construct(
        private readonly ShortCodeGenerator $codeGenerator,
        private readonly EntityManagerInterface $entityManager,
        private readonly TokenStorageInterface $tokenStorage
    ){
        parent::__construct();
    }

    #[Route('/link', name: 'app_link')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/LinkController.php',
        ]);
    }

    #[Route('/link/create')]
    public function create(Request $request): Response
    {
        $user = $this->tokenStorage->getToken()?->getUser();
        if (!$user instanceof User) {
            return new RedirectResponse('/login');
        }
        $originalUrl = $request->get('originalUrl');
        $linkEntity = null;
        if (filter_var($originalUrl, FILTER_VALIDATE_URL)) {
            $shortCode = $this->codeGenerator->generate();
            $linkEntity = new Link($originalUrl, $shortCode, 0, $user);
            $this->entityManager->persist($linkEntity);
            $this->entityManager->flush();
        }
        return $this->json($linkEntity?->getId());
    }

    #[Route('/link/list')]
    public function list(): JsonResponse
    {
        $result = $this->entityManager->getRepository(Link::class)->findAll();
        return $this->json($result);
    }

    #[Route('/link/get')]
    public function getByCode(Request $request): JsonResponse
    {
        $code = $request->query->get('code');
        $repository = $this->entityManager->getRepository(Link::class);
        $linkEntity = $repository->findOneBy(['shortCode' => $code]);

        if (!$linkEntity) {
            throw $this->createNotFoundException(
                'No product found for request '.$code
            );
        }

        return $this->json($linkEntity);
    }

    #[Route('/r')]
    public function codeRedirect(Request $request): RedirectResponse
    {
        $code = $request->query->get('code');
        $repository = $this->entityManager->getRepository(Link::class);
        $linkEntity = $repository->findOneBy(['shortCode' => $code]);

        if (!$linkEntity) {
            throw $this->createNotFoundException(
                'No product found for request '.$code
            );
        }

        $countTransition = $linkEntity->getCountTransition() + 1;
        $linkEntity->setCountTransition($countTransition);
        $this->entityManager->flush();

        return $this->redirect($linkEntity->getOriginalUrl());
    }

    #[Route('/link/delete')]
    public function delete (Request $request): Response
    {
        $user = $this->tokenStorage->getToken()?->getUser();
        if (!$user instanceof User) {
            return new RedirectResponse('/login');
        }
        $code = $request->query->get('code');
        $repository = $this->entityManager->getRepository(Link::class);
        $linkEntity = $repository->findOneBy(['shortCode' => $code]);

        if (!$linkEntity) {
            throw $this->createNotFoundException(
                'No product found for request ' . $code
            );
        }
        if( $linkEntity->getUser() !== $user) {
            throw  new \Exception('You are not owner ');
        }

        $this->entityManager->remove($linkEntity);
        $this->entityManager->flush();

        return $this->json([]);
    }
}
