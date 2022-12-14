<?php

namespace App\Controller;
use App\Form\SearchStudentType;
use App\Entity\Student;
use App\Form\StudentsType;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\PseudoTypes\True_;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\HttpFoundation\Request;


class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(): Response
    {
        return $this->render('Student/index.html.twig', [
            'controller_name' => 'StudentController',
        ]);
    }

    #[Route('/students', name: 'list_student')]
    public function listStudent(Request $request,StudentRepository $repository)
    {
        $students= $repository->findAll();
       // $students= $this->getDoctrine()->getRepository(StudentRepository::class)->findAll();
        $sortByMoyenne= $repository->sortByMoyenne();
       $formSearch= $this->createForm(SearchStudentType::class);
       $formSearch->handleRequest($request);
       $topStudents= $repository->topStudent();
       if($formSearch->isSubmitted()){
           $nce= $formSearch->get('nce')->getData();
           //var_dump($nce).die();
           $result= $repository->searchStudent($nce);
           return $this->renderForm("Student/list_student.html.twig",
               array("tabStudent"=>$result,
                   "sortByMoyenne"=>$sortByMoyenne,
                   "searchForm"=>$formSearch));
       }
         return $this->renderForm("Student/list_student.html.twig",
           array("tabStudent"=>$students,
               "sortByMoyenne"=>$sortByMoyenne,
                "searchForm"=>$formSearch,
               'topStudents'=>$topStudents));
    }

    #[Route('/addForm', name: 'add2')]
    public function addForm(ManagerRegistry $doctrine,Request $request)
    {
        $student= new Student;
        $form= $this->createForm(StudentsType::class,$student);
        $form->handleRequest($request) ;
        if ($form->isSubmitted()){
             $em= $doctrine->getManager();
             $em->persist($student);
             $em->flush();
             return  $this->redirectToRoute("list_student");
         }
        return $this->renderForm("Student/add.html.twig",array("formStudent"=>$form));
    }
    

    #[Route('/updateForm/{nce}', name: 'update')]
    public function  updateForm($nce,StudentRepository $repository,ManagerRegistry $doctrine,Request $request)
    {
        $student= $repository->find($nce);
        $form= $this->createForm(StudentsType::class,$student);
        $form->handleRequest($request) ;
        if ($form->isSubmitted()){
            $em= $doctrine->getManager();
            $em->flush();
            return  $this->redirectToRoute("list_student");
        }
        return $this->renderForm("Student/update.html.twig",array("formStudent"=>$form));
    }

    #[Route('/removeForm/{nce}', name: 'remove')]

    public function removeStudent(ManagerRegistry $doctrine,$nce,StudentRepository $repository)
    {
        $student= $repository->find($nce);
        $em = $doctrine->getManager();
        $em->remove($student);
        $em->flush();
        return  $this->redirectToRoute("list_student");
    }

    #[Route('/add2Form', name: 'add')]
    public function addStudent(ManagerRegistry $doctrine,Request $request,StudentRepository $repository)
    {
        $student=new Student();
        $form=$this->createForm(StudentsType::class,$student);
        $form->handleRequest($request) ;
        if ($form->isSubmitted()){
           $repository->add($student, true);
            return  $this->redirectToRoute("list_student");
        }
        return $this->renderForm("Student/add2.html.twig",array("formStudent"=>$form));
    }
}
