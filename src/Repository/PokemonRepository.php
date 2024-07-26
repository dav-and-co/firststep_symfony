<?php

namespace App\Repository;

use App\Entity\Pokemon;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pokemon>
 */
class PokemonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pokemon::class);
    }

    // création manuelle d'une nouvelle méthode de recherche d'une partie du title de la base pokemon
    public function findLikeTitle($search)
    {
        // initie une le constructeur de la création de la requète dans la table
        $queryBuilder = $this->createQueryBuilder('pokemon');
        // affecte à $query la requete de recherche dans la table pokemon ou
        $query = $queryBuilder->select('pokemon')
            // le titre contient le paramètre :search
            ->where('pokemon.title LIKE :search')
            // et affecte la valeur de search au paramètre :search avec une recherche partielle grace au %..%
            ->setParameter('search', '%'.$search.'%')
            //  et affecte ce résultat
            ->getQuery();
        // affecte au tableau pokémon ce résultat de la requète
        $pokemons = $query->getResult();

        return $pokemons;
    }

    //    /**
    //     * @return Pokemon[] Returns an array of Pokemon objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Pokemon
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
