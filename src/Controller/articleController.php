<?php

// permet de déclarer des types pour chacune des variables INT ...
declare(strict_types=1);

// localhost/piscine-2207-symfonyBase/public/articles

namespace App\Controller;
use App\Repository\PokemonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class articleController extends AbstractController
{
    private $pokemons;

    function __construct()
    {
        $this->pokemons = [
            [
                'id' => 1,
                'title' => 'Carapuce',
                'content' => 'Pokemon eau',
                'isPublished' => true,
                'im' => "img/carapuce.png"
            ],
            [
                'id' => 2,
                'title' => 'Salamèche',
                'content' => 'Pokemon feu',
                'isPublished' => true,
                'im' => 'img/remoi.jpeg'
            ],
            [
                'id' => 3,
                'title' => 'Bulbizarre',
                'content' => 'Pokemon plante',
                'isPublished' => true,
                'im' => 'img/moi.png'
            ],
            [
                'id' => 4,
                'title' => 'Pikachu',
                'content' => 'Pokemon electrique',
                'isPublished' => true,
                'im' => 'img/pikachu.png'
            ],
            [
                'id' => 5,
                'title' => 'Rattata',
                'content' => 'Pokemon normal',
                'isPublished' => false,
                'im' => 'img/pikachu.png'
            ],
            [
                'id' => 6,
                'title' => 'Roucool',
                'content' => 'Pokemon vol',
                'isPublished' => true,
                'im' => 'img/pikachu.png'
            ],
            [
                'id' => 7,
                'title' => 'Aspicot',
                'content' => 'Pokemon insecte',
                'isPublished' => false,
                'im' => 'img/pikachu.png'
            ],
            [
                'id' => 8,
                'title' => 'Nosferapti',
                'content' => 'Pokemon poison',
                'isPublished' => false,
                'im' => 'img/pikachu.png'
            ],
            [
                'id' => 9,
                'title' => 'Mewtwo',
                'content' => 'Pokemon psy',
                'isPublished' => true,
                'im' => 'img/pikachu.png'
            ],
            [
                'id' => 10,
                'title' => 'Ronflex',
                'content' => 'Pokemon normal',
                'isPublished' => false,
                'im' => 'img/pikachu.png'
            ]

        ];
    }

    #[Route('/articles', name: 'list_Articles')]
    public function listArticles()
    {

        return $this->render('page/Articles.html.twig', [
            'pokemons' => $this->pokemons
        ]);
    }

    #[Route('/article/{id}', name: 'one_Article')]
    public function oneArticle($id): Response
    {

        // est remplacé par la création d'un instance de la class dans la fonction
//    $request = Request::createfromGlobals();


        $pokemonFound = null;

        foreach ($this->pokemons as $pokemon) {
            if ($pokemon['id'] === (int)$id) {
                $pokemonFound = $pokemon;
            }
        }
        return $this->render('page/Article.html.twig', [
            'pokemon' => $pokemonFound
        ]);
    }

// localhost/piscine-2207-symfonyBase/public/pokemon-list-db

// function qui récupère les données de la BDD
    #[Route('/pokemon-list-db', name: 'pokemon_list_db')]
    public function listPokemonFromDb(PokemonRepository $pokemonRepository) : response {
        // récupère tous les pokemons en BDD

        $pokemons = $pokemonRepository->findAll();


        return $this->render('page/pokemon_list_db.html.twig', [
            'pokemons' => $pokemons
        ]);
    }



}


// autre méhode en utilisant le get dans l'url

//    #[Route('/article', name: 'one_Article')]
//    public function oneArticle(Request $request) : Response {
//
//        // est remplacé par la création d'un instance de la class dans la fonction
//    $request = Request::createfromGlobals();
//        $id = (int)($request->query->get('id'));
//        $pokemonFound = null;

//        foreach ($this->pokemons as $pokemon) {
//            if($pokemon['id'] === (int)$id) {
//                $pokemonFound = $pokemon;
//            }
//        }
//        return $this->render('page/Article.html.twig', [
//            'pokemon' => $pokemonFound
//        ]);
//    }
//}



