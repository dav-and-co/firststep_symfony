<?php

// localhost/piscine-2207-symfonyBase/public/categories

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class categoryController extends AbstractController
{

#[Route('/categories', name: 'list_category')]
public function listCategory(){
    $categories = [
        'Red', 'Green', 'Blue', 'Yellow', 'Gold', 'Silver', 'Crystal'
    ];

 $html=$this->renderview('page/Category.html.twig', [
     'categories' => $categories
      ]);

    return new Response($html, 200);
    }
}



