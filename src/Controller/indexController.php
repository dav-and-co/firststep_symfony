<?php

// localhost/piscine-2207-symfonyBase/public/


// definition du chemin de fichier concerné (app (à la place de sec) puis répertoire controller
namespace App\Controller;
// permet d'utiliser la classe AbstractController de symfony
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// permet d'utiliser la classe Route de symfony
use Symfony\Component\Routing\Attribute\Route;

//création de la class du controller
class indexController extends AbstractController

{
    // création de l'affichage de l'adresse intenet et renvoi vers ce controller
    #[Route('/', name: 'index')]
    public function index(){
       return $this->render (view:'page/index.html.twig');
    }
 }
