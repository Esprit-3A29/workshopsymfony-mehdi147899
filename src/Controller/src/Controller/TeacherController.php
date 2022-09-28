<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    #[Route('/teacher/base{var}', name: 'app_teacher')]
    public function Listteacher($nom)
    {
        $this->render("la liste des professeurs: " ,['nom'=>$nom]);
    }
}

