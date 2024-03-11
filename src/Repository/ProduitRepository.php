<?php

namespace App\Repository;

use App\Entity\Produit;
use App\Entity\Categorie;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Produit>
 *
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }


    public function findProduitsByVendeurRegion(string $departementId, $categorieId): array
    {
        return $this->createQueryBuilder('p')
            ->innerJoin('p.vendeur', 'u')
            ->where('u.cp LIKE :cp')
            ->andWhere('p.categories = :idCategorie ' )
            ->setParameter('cp', $departementId.'%')
            ->setParameter('idCategorie', $categorieId)
            ->getQuery()
            ->getResult();
    }
    public function countProduitsByCategorie(Categorie $categorie, $departementId): int
    {
        return $this->createQueryBuilder('p')
        ->select('COUNT(p)')
        ->innerJoin('p.vendeur', 'u')
        ->where('p.categories = :categorie')
        ->andWhere('u.cp LIKE :cp')
        ->setParameter('categorie', $categorie)
        ->setParameter('cp', $departementId . '%')
        ->getQuery()
        ->getSingleScalarResult();
    }

}
