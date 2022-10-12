<?php

namespace App\Controller;
use App\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StudentController extends AbstractController
{
    #[Route('/Student', name: 'bonjourstudent')]

    public function accueil(): Response
    {
        return new Response("bonjour mes etudiants");

    }
    #[Route('/Students', name: 'app_student')]

    public function clublist(StudentRepository $repository)
    {
        $clubs=$repository->findAll();
        return $this->render("Student/Student.html.twig", array("student_tab"=>$clubs));
    }

}
