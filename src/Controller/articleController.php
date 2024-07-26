<?php

// permet de déclarer des types pour chacune des variables INT ...
declare(strict_types=1);

// localhost/piscine-2207-symfonyBase/public/articles

namespace App\Controller;
use App\Repository\PokemonRepository;
use Doctrine\ORM\EntityManagerInterface;
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

// function qui récupère UNE donnée de la BDD au travers du choix de l'ID sur l'affichage de tous les articles
    #[Route('/pokemon-one-db/{id}', name: 'pokemon_one_db')]
    public function onePokemonFromDb(INT $id, PokemonRepository $pokemonRepository) : response {
        // récupère 1 pokemons en BDD par son id

        $pokemon = $pokemonRepository->find($id);


        return $this->render('page/pokemon_one_db.html.twig', [
            'pokemon' => $pokemon
        ]);
    }

    //rechercher un pokemon de la BDD à partir de son nom (title)
    // localhost/piscine-2207-symfonyBase/public/pokemon-db/search/title

    #[Route('/pokemon-db/search/title', name: 'pokemon_search')]
    public function searchPokemon(Request $request, PokemonRepository $pokemonRepository): Response
    {
        $pokemonFound = null;

        if ($request->request->has('title')) {

            $titleSearched = $request->request->get('title');
            $pokemonFound = $pokemonRepository->findOneBy(['title' => $titleSearched]);
            if (!$pokemonFound) {
                $html = $this->renderView('page/404.html.twig');
                return new Response($html, 404);
            }
        }

        return $this->render('page/pokemon_search.html.twig', [
            'pokemon' => $pokemonFound
        ]);
    }


    //rechercher un pokemon de la BDD à partir d'un partie du  nom (title)
    // localhost/piscine-2207-symfonyBase/public/pokemon-db/search/partial
    #[Route('/pokemon-db/search/partial', name: 'pokemon_search-partial')]
    public function searchPokemonpartial(Request $request, PokemonRepository $pokemonRepository): Response
    {
        $pokemonsFound = [];
        // vérifie s'il y a une valeur dans la varible title envoyée par le POST
        if ($request->request->has('title')) {
            // va recupérer la valeur saisie via une requète qui récupere le POST et l'affecte à une variable
            $titleSearched = $request->request->get('title');
            // fait appel à une methode de recherche partielle inexistante dans synfony mis créée directement dans le repository de pokemon
            $pokemonsFound = $pokemonRepository->findLikeTitle($titleSearched);

            //si la longueur du tableau de retour est 0 (donc vide car pas de correspondance), affiche la page d'erreur
            if (count($pokemonsFound) === 0) {
                $html = $this->renderView('page/404.html.twig');
                return new Response($html, 404);
            }
        }
        //sinon affiche le retour en passant le tableau en données
        return $this->render('page/pokemon_search_partial.html.twig', [
            'pokemons' => $pokemonsFound
        ]);
    }

    // supprimer un pokemon

    // localhost/piscine-2207-symfonyBase/public/pokemon-db/delete
    #[Route('/pokemon-db/delete/{id}', 'pokemon_delete')]
    public function deletePokemon(int $id, Request $request, PokemonRepository $pokemonRepository, EntityManagerInterface $entityManager): Response
    {
        $pokemon = $pokemonRepository->find($id);
        if ($pokemon === null) {
            $html = $this->renderView('page/404.html.twig');
            return new Response($html, 404);
        }
        // j'utilise la classe entity manager pour préparer la requête SQL de suppression cette requête n'est pas executée tout de suite
        $entityManager->remove($pokemon);
        // j'execute la / les requête SQL préparée
        $entityManager->flush();

        return $this->redirectToRoute('pokemon_list_db');
    }

}






