<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Film;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Film>
 *
 * @method Film|null find($id, $lockMode = null, $lockVersion = null)
 * @method Film|null findOneBy(array $criteria, array $orderBy = null)
 * @method Film[]    findAll()
 * @method Film[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilmRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Film::class);
    }

    public function sort(string $search = null, SearchData $searchData): array
    {
        $queryBuilder = $this->createQueryBuilder('r')
            ->select('r')
            ->leftJoin('r.genre', 'g')
            ->leftJoin('r.realisateur', 're')
            ->leftJoin('r.acteur', 'a')
            ->orderBy('r.vu', 'ASC')
            ->addOrderBy('r.name', 'ASC');

        if ($search) {
            $queryBuilder->andWhere('r.name LIKE :searchTerm')
                ->setParameter('searchTerm', '%'.$search.'%');
        }

        if (!empty($searchData->genre)) {
            $queryBuilder = $queryBuilder
                ->andWhere('g.id IN (:genre)')
                ->setParameter('genre', $searchData->genre);
        }

        if (!empty($searchData->realisateur)) {
            $queryBuilder = $queryBuilder
                ->andWhere('re.id IN (:realisateur)')
                ->setParameter('realisateur', $searchData->realisateur);
        }

        if (!empty($searchData->acteur)) {
            $queryBuilder = $queryBuilder
                ->andWhere('a.id IN (:acteur)')
                ->setParameter('acteur', $searchData->acteur);
        }

        $films = $queryBuilder->getQuery()->getResult();

        return $films;
    }

}
