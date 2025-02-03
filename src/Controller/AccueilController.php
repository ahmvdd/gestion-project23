<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\FormTicketType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class AccueilController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    #[Route('/', name: 'app_accueil')]
    public function index(Request $request): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(FormTicketType::class, $ticket);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($ticket);
            $this->entityManager->flush();

            // Redirect or display success message
        }

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'form' => $form->createView()
        ]);
    }

}
