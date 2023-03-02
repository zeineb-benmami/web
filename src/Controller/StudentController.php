<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StudentRepository;
use App\Entity\Student;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\StudentType;

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
        return $this->render('student/ll.html.twig', [
            'st'=>$repo->findAll(),
            
        ]);
    }


    #[Route('/r/{id}', name: 'remove2')]
    public function remove(ManagerRegistry $mr,$id,StudentRepository $repo): Response
    {
       
            $a=$repo->find($id);
            $em=$mr->getManager();
            $em->remove($a);
            $em->flush();

            return new Response('removed');
            
       
    }


    



    #[Route('/addstudent', name: 'addstudent')]
    public function addstudent(ManagerRegistry $mr): Response
    {
        $a=new Student();
        //$a->setEmail('zzzzzz');
        $f=$this->createForm(StudentType::class,$a);
        $em=$mr->getManager();
        $em->persist($a) ;
        $em->flush();
        return new Response('added');
    }

}
