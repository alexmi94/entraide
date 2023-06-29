<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;

class PostController extends AbstractController
{
    private $entityManager;
    private $security;


    public function __construct(ManagerRegistry $managerRegistry, Security $security, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
    }


    #[Route('/post/{id}', name: 'app_post')]
    public function index($id, Request $request): Response
    {

        $post = $this->entityManager->getRepository(Post::class)->find($id);


        

        return $this->render('post/index.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/post/newcommentaire', name: 'app_post')]
    public function newcommentaire(Post $post, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        $user->addFavori($logement);
        $entityManager->flush();

        return $this->redirectToRoute('app_logement', ['id' => $logement->getId()]);
    }
}
