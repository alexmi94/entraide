<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;

class MonCompteController extends AbstractController
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

    #[Route('/compte', name: 'app_compte')]
    public function index(): Response
    {

        $user = $this->security->getUser();


        return $this->render('compte/index.html.twig', [
            'user' => $user,
        ]);
    }
}
