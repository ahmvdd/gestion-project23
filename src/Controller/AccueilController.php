<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Form\FormTicketType;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class AccueilController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Security $security,
        private TicketRepository $ticketRepository
    ) {
    }

    #[Route('/', name: 'app_accueil')]
    public function index(Request $request): Response
    {
        $ticket = new Ticket();
        $form = $this->createForm(FormTicketType::class, $ticket);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer l'utilisateur connecté
            $user = $this->security->getUser();
            
            // Associer l'utilisateur au ticket
            if ($user) {
                $ticket->setCreatedBy($user);
            }

            $this->entityManager->persist($ticket);
            $this->entityManager->flush();

            $this->addFlash('success', 'Ticket créé avec succès.');
            return $this->redirectToRoute('app_accueil');
        }

        $user = $this->security->getUser();
        $allTickets = null;

        if ($user && $this->security->isGranted('ROLE_ADMIN')) {
            $allTickets = $this->ticketRepository->findAll();
        }

        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
            'form' => $form->createView(),
            'tickets' => $allTickets
        ]);
        
    }

    #[Route('/ticket/{id}', name: 'app_ticket_view')]
    public function view(Ticket $ticket): Response
    {
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Accès refusé.');
        }
    
        return $this->render('accueil/index.html.twig', [
            'ticket' => $ticket,
            'view_mode' => 'details'
        ]);
    }
    
    #[Route('/ticket/{id}/edit', name: 'app_ticket_edit')]
    public function edit(Request $request, Ticket $ticket): Response
    {
        if (!$this->security->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Accès refusé.');
        }
    
        $form = $this->createForm(FormTicketType::class, $ticket);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            return $this->json(['message' => 'Ticket modifié avec succès.']);
        }
    
        return $this->render('accueil/index.html.twig', [
            'form' => $form->createView(),
            'ticket' => $ticket,
            'view_mode' => 'edit'
        ]);
    }
    

    
}
