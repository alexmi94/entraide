<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;

class PostController extends AbstractController
{
    private $entityManager;
    private $security;
    private $managerRegistry;


    public function __construct(ManagerRegistry $managerRegistry, Security $security, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->managerRegistry = $managerRegistry;
    }


    #[Route('/post/{id}', name: 'app_post')]
    public function index($id, Request $request): Response
    {

        $user = $this->security->getUser();

        $post = $this->entityManager->getRepository(Post::class)->find($id);

        // Create a new Comment instance
        $comment = new Comment();
        
        // Create the form for adding a comment
        $form = $this->createFormBuilder($comment)
            ->add('content', TextareaType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setPost($post);
            $comment->setUser($user);
            $currentDate = new \DateTime();
            $formattedDate = $currentDate->format('Y-m-d');
            $comment->setDate($formattedDate);
    
            $entityManager = $this->managerRegistry->getManager();
            $this->entityManager->persist($comment);
            $this->entityManager->flush();

            // Clear the comment object for a new form
            $comment = new Comment();
            $form = $this->createFormBuilder($comment)
                ->add('content', TextareaType::class)
                ->getForm();
        }
        

        return $this->render('post/index.html.twig', [
            'form' => $form,
        ]);
    }
}
