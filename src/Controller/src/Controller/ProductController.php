<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {
        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/list/{var}', name: 'list_product')]
    public function ListProduct($var)
    {
        return new  Response("la liste des produits: " .$var);
    }
    
    #[Route('/show', name: 'show_product')]
    public function showProduct()
    {
        return $this->render("product/show.html.twig");
    }
    #[Route('/list', name: 'showlist')]
    public function showlist()
    {
        $var1 = "2A29";
        $var2= "i26";
        $formations = array(
            array('ref' => 'form147', 'Titre' => 'Formation Symfony
            4','Description'=>'pratique',
            'date_debut'=>'12/06/2020', 'date_fin'=>'19/06/2020',
            'nb_participants'=>19) ,
            array('ref'=>'form177','Titre'=>'Formation SOA' ,
            'Description'=>'theorique','date_debut'=>'03/12/2020','date_fin'=>'10/12/2020',
            'nb_participants'=>0),
            array('ref'=>'form178','Titre'=>'Formation Angular' ,
            'Description'=>'theorique','date_debut'=>'10/06/2020','date_fin'=>'14/06/2020',
            'nb_participants'=>12));
        return $this->render("product/list.html.twig", array('classe'=>$var1,'salle'=>$var2, 'tab_formations'=>$formations));
    }
    #[Route('/reservation', name: 'app_reservation')]

    public function reservation()
    {
        return new Response (content:"nouvelle page");
    }
}

