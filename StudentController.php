<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry ;
use App\Repository\StudentRepository;
use App\Entity\Student ;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    #[Route('/getstudent', name: 'getstudent')]
    public function getstudent(StudentRepository $repo): Response
    {
        return $this->render('student/list.html.twig', [
            'p' => $repo->findAll(),
        ]);
    }
    #[Route('/removesc/{id}', name: 'removesc')]
    public function removearticle(ManagerRegistry $mr,$id,StudentRepository $repo): Response
    {   $a=$repo->find($id);
        $em=$mr->getManager();
        $em->remove($a);
        $em->flush();
        return new Response('removed');
    }
}
