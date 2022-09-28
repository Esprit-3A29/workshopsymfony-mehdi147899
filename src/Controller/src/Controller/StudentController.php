<?php

namespace App\Controller;

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

}
