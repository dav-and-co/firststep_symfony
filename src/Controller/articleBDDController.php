<?php

// permet de déclarer des types pour chacune des variables INT ...
declare(strict_types=1);

// localhost/piscine-2207-symfonyBase/public/articles

namespace App\Controller;
use App\Entity\Pokemon;
use App\Form\PokemonType;
use App\Repository\PokemonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class articleBDDController extends AbstractController
{

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


    // localhost/piscine-2207-symfonyBase/public/pokemons-db/insert
    #[Route('/pokemons-db/insert', name: 'pokemon_insert')]
        public function insertPokemon(EntityManagerInterface $entityManager, Request $request) : Response
    {
        // j'initialise la variable
        // $pokemon à null
        // car on va l'envoyer à twig (et on fera une vérif dans twig)
        $pokemon = null;
        $error = null;
        // je vérifie si la requête est du POST
        // donc si le form a été envoyé
        if ($request->getMethod() === 'POST') {
            // je récupère les données envoyées par l'utilisateur
            $title = $request->request->get('title');
            $description = $request->request->get('description');
            $image = $request->request->get('image');
            $type = $request->request->get('type');

            // les try catch permettent d'executer du code, tout
            // en récupérant les erreurs potentiels
            // afin de les gérer correctement (affichage de page spécifique etc)
            try {
                $pokemon = new Pokemon();
                $pokemon->setTitle($title);
                $pokemon->setDescription($description);
                $pokemon->setImage($image);
                $pokemon->setType( $type);

                $entityManager->persist($pokemon);
                $entityManager->flush();
                return $this->redirectToRoute('pokemon_list_db');

            } catch (\Exception $errorMessage) {
                $error = $errorMessage->getMessage();
            }
        }
        return $this->render('page/pokemon_insert.html.twig', [
            'pokemon' => $pokemon, 'error' => $error
        ]);
    }

    // fonction de modification d'un pokémon existant
    // intégration dans la route de l'id à récupérer dans la barre (suite clic bouton sur liste des pokémons)
    #[Route('/pokemons/pokemon_update/{id}', name:'pokemon_update')]
    //initialisation des classes et de l'id sais pour la création de la méthode
    public function updatePokemon(int $id, PokemonRepository $pokemonRepository, Request $request, EntityManagerInterface $entityManager)
    {

        //la variable $pokemon recupère le pokemon sur l'id demandé
        $pokemon = $pokemonRepository->find($id);
        // génére une instance de la classe de gabarit de formulaire (form/PokemonType), avec l'instance créée ligne précédente
        $pokemonUpdateForm = $this->createForm(PokemonType::class, $pokemon);
        // associe le formulaire avec la requête
        $pokemonUpdateForm->handleRequest($request);
        // sur clic du submitt et contrôle des contraintes
        if ($pokemonUpdateForm->isSubmitted() && $pokemonUpdateForm->isValid()) {
            // prepare l'insertion de la modif et la stocke
            $entityManager->persist($pokemon);
            // ecrit dans la table la modif
            $entityManager->flush();
            //si modif enregitrée, boucle vers la page de la liste des pokemons
            return $this->redirectToRoute('pokemon_list_db');
        }
        //retour de la fonction après ou avant traitement : affichage de la page  pokemon_update.html.twig
        return $this->render('page/pokemon_update.html.twig', [
            'pokemonUpdateForm' => $pokemonUpdateForm->createView()
        ]);
    }

}





