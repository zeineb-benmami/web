<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ClassroomRepository;
use App\Entity\Classroom;
use Doctrine\Persistence\ManagerRegistry ;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ClassroomType;

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



    
    #[Route('/addclass', name: 'addclass')]
    public function addclub(ManagerRegistry $mr, Request $req): Response
    {
        $a=new Classroom();
       
        $f=$this->createForm(ClassroomType::class,$a);
        $f->handleRequest($req);
        if($f->isSubmitted()){
        $em=$mr->getManager();
        $em->persist($a) ;
        $em->flush();
        return $this->redirectToRoute('getclass');
        }
        //return new Response('added');
        return $this->render('classroom/lcl.html.twig', [
            'formclassroom'=>$f->createView()
            
        ]);
    }


    #[Route('/updatec/{id}', name: 'updatec')]
    public function updateStudent(ManagerRegistry $mr, Request $req , $id): Response
    {
        $a=$mr->getRepository(Classroom::class)->find($id);
        
        $f=$this->createForm(ClassroomType::class,$a);
        $f->handleRequest($req);

        if($f->isSubmitted()){

            $ref=$mr->getRepository(Classroom::class)->find($a->getId());
            dd($ref);
            $name=$a->getName();
            $a->setName($name);
            if($ref==null){
        $em=$mr->getManager();
        $em->persist($a) ;
        $em->flush();
            }
            else{
                return new Response ('ref existe!');
            }
        return $this->redirectToRoute('getclass');
        }
        //return new Response('added');
        return $this->render('classroom/lcl.html.twig', [
            'formclassroom'=>$f->createView()
            
        ]);
    }
}
