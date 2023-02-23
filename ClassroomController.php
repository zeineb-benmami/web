<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry ;
use App\Repository\ClassroomRepository;
use App\Entity\Student ;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }
    #[Route('/listc', name: 'listc')]
    public function listc(ClassroomRepository $repo): Response
    {
        return $this->render('classroom/list.html.twig', [
            'p' => $repo->findAll(),
        ]);
    }
    #[Route('/removec/{id}', name: 'removec')]
    public function removearticle(ManagerRegistry $mr,$id,ClassroomRepository $repo): Response
    {   $a=$repo->find($id);
        $em=$mr->getManager();
        $em->remove($a);
        $em->flush();
        return new Response('removed');
    }
}
