<?php

// localhost/piscine-2207-symfonyBase/public/articles

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class articleController extends AbstractController
{

#[Route('/articles', name: 'list_Articles')]
public function listArticles(){
    $pokemons = [
        [
            'id' => 1,
            'title' => 'Carapuce',
            'content' => 'Pokemon eau',
            'isPublished' => true
        ],
        [
            'id' => 2,
            'title' => 'Salamèche',
            'content' => 'Pokemon feu',
            'isPublished' => true
        ],
        [
            'id' => 3,
            'title' => 'Bulbizarre',
            'content' => 'Pokemon plante',
            'isPublished' => true
        ],
        [
            'id' => 4,
            'title' => 'Pikachu',
            'content' => 'Pokemon electrique',
            'isPublished' => true
        ],
        [
            'id' => 5,
            'title' => 'Rattata',
            'content' => 'Pokemon normal',
            'isPublished' => false
        ],
        [
            'id' => 6,
            'title' => 'Roucool',
            'content' => 'Pokemon vol',
            'isPublished' => true
        ],
        [
            'id' => 7,
            'title' => 'Aspicot',
            'content' => 'Pokemon insecte',
            'isPublished' => false
        ],
        [
            'id' => 8,
            'title' => 'Nosferapti',
            'content' => 'Pokemon poison',
            'isPublished' => false
        ],
        [
            'id' => 9,
            'title' => 'Mewtwo',
            'content' => 'Pokemon psy',
            'isPublished' => true
        ],
        [
            'id' => 10,
            'title' => 'Ronflex',
            'content' => 'Pokemon normal',
            'isPublished' => false
        ]

    ];

   return $this->render('page/Articles.html.twig', [
       'pokemons' => $pokemons
    ]);
    }
}



