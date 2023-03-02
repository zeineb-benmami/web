<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ClassroomRepository;
use App\Entity\Classroom;
use Doctrine\Persistence\ManagerRegistry ;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }

    #[Route('/getclass', name: 'getclass')]
    public function getclass(ClassroomRepository $repo): Response
    {
        return $this->render('classroom/lclass.html.twig', [
            'st'=>$repo->findAll(),
            
        ]);
    }


    #[Route('/rmv/{id}', name: 'remove4')]
    public function remove(ManagerRegistry $mr,$id,ClassroomRepository $repo): Response
    {
       
            $a=$repo->find($id);
            $em=$mr->getManager();
            $em->remove($a);
            $em->flush();

            return new Response('removed');
            
       
    }
}
