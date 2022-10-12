<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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

public function addclass(ManagerRegistry $doctrine)
{
    $classroom = new Classroom;
    $form = $this->createForm(ClassroomformType::class, $classroom);
    return $this->renderForm("classroom.html.twig",array("classroomformtype"=>$form->createView()));

    //$em = $this->getDoctrine()->getManager
    $em=$doctrine->getManager();
    $em->persist($classroom);
    $em->flush();
    return $this->redirectToRoute("list_classroom");

}
#[Route('/updateForm/{id}', name: 'update')]

public function update(ManagerRegistry $doctrine)
{
    $classroom = new Classroom;
    $form = $this->createForm(ClassroomformType::class, $classroom);
    return $this->renderForm("classroom.html.twig",array("classroomformtype"=>$form->createView()));

    //$em = $this->getDoctrine()->getManager
    $em=$doctrine->getManager();
    $em->flush();
    return $this->redirectToRoute("list_classroom");

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
