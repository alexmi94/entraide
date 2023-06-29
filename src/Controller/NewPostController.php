<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Post;
use App\Form\NewpostType;
use Symfony\Component\HttpFoundation\Request;

class NewPostController extends AbstractController
{

    private $security;
    private $entityManager;
    private $managerRegistry;

    public function __construct(ManagerRegistry $managerRegistry, Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
        $this->managerRegistry = $managerRegistry;
    }

    #[Route('/newpost', name: 'app_new_post')]
    public function index(Request $request): Response
    {

        $user = $this->security->getUser();

        $post = new Post();
        $form = $this->createForm(NewpostType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $post->setUser($user);
            $currentDate = new \DateTime();
            $formattedDate = $currentDate->format('Y-m-d');
            $post->setDate($formattedDate);

            $entityManager = $this->managerRegistry->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        

        return $this->render('new_post/index.html.twig', [
            'form' => $form,
        ]);
    }
}
