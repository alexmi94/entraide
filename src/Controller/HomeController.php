<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Post;

class HomeController extends AbstractController
{
    private $entityManager;
    private $managerRegistry;


    public function __construct(ManagerRegistry $managerRegistry, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->managerRegistry = $managerRegistry;
    }


    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {

        $posts = $this->entityManager->getRepository(Post::class)->findBy([], ['id' => 'DESC']);

        return $this->render('home/index.html.twig', [
            'posts' => $posts ,
        ]);
    }
}
