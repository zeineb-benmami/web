<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry ;
use App\Repository\ClubRepository;
use App\Entity\Club;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ClubType;
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



    #[Route('/addclub', name: 'addclub')]
    public function addclub(ManagerRegistry $mr, Request $req): Response
    {
        $a=new Club();
       
        $f=$this->createForm(ClubType::class,$a);
        $f->handleRequest($req);
        if($f->isSubmitted()){
        $em=$mr->getManager();
        $em->persist($a) ;
        $em->flush();
        return $this->redirectToRoute('getclub');
        }
        //return new Response('added');
        return $this->render('club/lc.html.twig', [
            'formclub'=>$f->createView()
            
        ]);
    }


    #[Route('/updateclub/{id}', name: 'updateclub')]
    public function updateStudent(ManagerRegistry $mr, Request $req , $id): Response
    {
        $a=$mr->getRepository(Club::class)->find($id);
        
        $f=$this->createForm(ClubType::class,$a);
        $f->handleRequest($req);

        if($f->isSubmitted()){

            $ref=$mr->getRepository(Club::class)->find($a->getREF());
            dd($ref);
            $createdAt=$a->getcreatedAt();
            $a->setCreatedAt($createdAt);
            if($ref==null){
        $em=$mr->getManager();
        $em->persist($a) ;
        $em->flush();
            }
            else{
                return new Response ('ref existe!');
            }
        return $this->redirectToRoute('getclub');
        }
        //return new Response('added');
        return $this->render('club/lc.html.twig', [
            'formclub'=>$f->createView()
            
        ]);
    }
}
