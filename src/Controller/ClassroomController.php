<?php

namespace App\Controller;
use App\Form\ClassroomType;
use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use App\Repository\StudentRepository;
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
    #[Route('/list_classroom/{id}', name: 'list_clasroom')]

public function afficherlist($id,ClassroomRepository $repository,StudentRepository $repo)
{
    $classroom= $repository->find($id);
    $students= $repo->getStudentByClassroom($id);
    return $this->render("classroom/classroom.html.twig", array("clasroom_tab"=>$classroom, "student_tab"=>$students));


}
#[Route('/add_classroom', name: 'add_classroom')]

public function addclass(ManagerRegistry $doctrine, Request $request,ClassroomRepository $repository)
{   
    $classroom =new ClassRoom;
    $form =$this->createForm(ClassroomType::class,$classroom);
    $form->handleRequest($request);
    if($form->isSubmitted())
    {
        $repository->add($classroom,true);
        return $this->redirectToRoute("list_clasroom");
    }
    return $this->renderForm("classroom/add.html.twig",array("formClassroom"=>$form));

}
#[Route('/updateForm/{id}', name: 'update_classroom')]

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
#[Route('/remove_classroom/{id}', name: 'delete_classroom')]

public function removeclass($id, ManagerRegistry $doctrine,ClassroomRepository $repository)
{
$classroom= $repository->find($id);
$em= $doctrine->getManager();
$em->remove($classroom);
$em->flush();
return $this->redirectToRoute("list_clasroom");
}


}
