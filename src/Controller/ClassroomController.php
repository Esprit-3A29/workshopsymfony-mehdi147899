<?php

namespace App\Controller;
use App\Form\ClassroomType;
use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    #[Route('/classroom', name: 'app_classroom')]
    public function index(): Response
    {
        return $this->render('classroom/index.html.twig', [
            'controller_name' => 'ClassroomController',
        ]);
    }
    #[Route('/list_classroom', name: 'list_clasroom')]

public function afficherlist(ClassroomRepository $repository)
{
    $list= $repository->findAll();
    return $this->render("classroom/classroom.html.twig", array("clasroom_tab"=>$list));


}
#[Route('/add_classroom', name: 'add')]

public function addclass(ManagerRegistry $doctrine, Request $request)
{
    $classroom =new ClassRoom;
    $form =$this->createForm(ClassroomType::class,$classroom);
    $form->handleRequest($request);
    if($form->isSubmitted())
    {
        $em=$doctrine->getManager($request);
        $em->persist($classroom);
        $em->flush();
        return $this->redirectToRoute("list_classroom");
    }
    return $this->renderForm("classroom/add.html.twig",array("formClassroom"=>$form));

}
#[Route('/updateForm/{id}', name: 'update')]

public function update($id,ClassRoomRepository $repository ,ManagerRegistry $doctrine,Request $request)
{
    $classroom= $repository->find($id);
        $form= $this->createForm(ClassroomType::class,$classroom);
        $form->handleRequest($request) ;
        if ($form->isSubmitted()){
            $em= $doctrine->getManager();
            $em->flush();
            return  $this->redirectToRoute("list_clasroom");
        }
        return $this->renderForm("classroom/update.html.twig",array("formClassroom"=>$form));
}
#[Route('/remove_classroom/{id}', name: 'remove')]

public function removeclass($id, ManagerRegistry $doctrine,ClassroomRepository $repository)
{
$classroom= $repository->find($id);
$em= $doctrine->getManager();
$em->remove($classroom);
$em->flush();
return $this->redirectToRoute("list_clasroom");
}


}
