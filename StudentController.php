<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StudentRepository;
use App\Entity\Student;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\StudentType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

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
    public function addstudent(ManagerRegistry $mr, Request $req): Response
    {
        $a=new Student();
        //$a->setEmail('zzzzzz');
        $f=$this->createForm(StudentType::class,$a);
        $f->handleRequest($req);
        if($f->isSubmitted()){
        $em=$mr->getManager();
        $em->persist($a) ;
        $em->flush();
        return $this->redirectToRoute('getstudent');
        }
        //return new Response('added');
        return $this->render('student/ls.html.twig', [
            'formstudent'=>$f->createView()
            
        ]);
    }


    #[Route('/updatestudent/{id}', name: 'updatestudent')]
    public function updateStudent(ManagerRegistry $mr, Request $req , $id): Response
    {
        $a=$mr->getRepository(Student::class)->find($id);
        
        $f=$this->createForm(StudentType::class,$a);
        $f->handleRequest($req);

        if($f->isSubmitted()){

            $ref=$mr->getRepository(Student::class)->find($a->getNSC());
            dd($ref);
            $email=$a->getEmail();
            $a->setEmail($email);
            if($ref==null){
        $em=$mr->getManager();
        $em->persist($a) ;
        $em->flush();
            }
            else{
                return new Response ('ref existe!');
            }
        return $this->redirectToRoute('getstudent');
        }
        //return new Response('added');
        return $this->render('student/ls.html.twig', [
            'formstudent'=>$f->createView()
            
        ]);
    }

}
