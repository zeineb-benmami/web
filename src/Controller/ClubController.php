<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry ;
use App\Repository\ClubRepository;
use App\Entity\Club;
class ClubController extends AbstractController
{
    #[Route('/club', name: 'app_club')]
    public function index(): Response
    {
        return $this->render('club/index.html.twig', [
            'controller_name' => 'ClubController',
        ]);
    }

    #[Route('/getclub', name: 'getclub')]
    public function getclub(ClubRepository $repo): Response
    {
        return $this->render('club/lclub.html.twig', [
            'st'=>$repo->findAll(),
            
        ]);
    }


    #[Route('/rm/{id}', name: 'remove3')]
    public function remove(ManagerRegistry $mr,$id,ClubRepository $repo): Response
    {
       
            $a=$repo->find($id);
            $em=$mr->getManager();
            $em->remove($a);
            $em->flush();

            return new Response('removed');
            
       
    }
}
