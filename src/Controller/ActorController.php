<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\ActorRepository;
use App\Entity\Actor;
use Symfony\Component\HttpFoundation\Request;

#[Route('/actor', name: 'actor_')]
class ActorController extends AbstractController
{
    #[Route('/{id<^[0-9]+$>}', name: 'show')]
    public function show( Actor $actor, ActorRepository $actorRepository): Response 
    {
        $programs = $actor->getPrograms();
        if(!$actor) {
            throw $this->createNotFoundException(
                'No actor with id : '.$id. ' found in actor\'s table.'            
            );
        }
        return $this->render('actor/show.html.twig', [
            'actor' => $actor,
            'programs' => $programs
        ]);
    }
}