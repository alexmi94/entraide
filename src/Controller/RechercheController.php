<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Entity\Post;
use App\Form\RechercheType;


class RechercheController extends AbstractController
{
    private $entityManager;


    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/recherche', name: 'app_recherche')]
    public function index(Request $request): Response
    {   
        
        $form = $this->createForm(RechercheType::class);
        $form->handleRequest($request);

        $Post = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $theme = $form->getData()['theme'];
            $Post = $this->entityManager->getRepository(Post::class)->findBy(['theme' => $theme]);
        }

        return $this->render('recherche/index.html.twig', [
            'posts' => $Post,
            'form' => $form
        ]);
    }
}
