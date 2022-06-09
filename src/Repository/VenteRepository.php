<?php

namespace App\Repository;

use App\Entity\Produit;
use App\Entity\Vente;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vente>
 *
 * @method Vente|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vente|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vente[]    findAll()
 * @method Vente[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VenteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vente::class);
    }

    public function add(Vente $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Vente $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllAnnonce()
    {
        return $this->createQueryBuilder('v')
            ->orderBy('v.date_vente', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function mesventes($utilisateur)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.utilisateur = :utilisateur_id')
            ->orderBy('v.date_vente', 'DESC')
            ->setParameter('utilisateur_id', $utilisateur)
            ->getQuery()
            ->getResult()
        ;
    }



    // public function findAllAnnonce(): array
    // {
    //     $entityManager = $this->getEntityManager();

    //     $query = $entityManager->createQuery(
    //         'SELECT p.nom
    //         FROM App\Entity\Vente v
    //         JOIN App\Entity\Produit p
    //         WHERE v.produit= p.id
    //         ORDER BY v.date_vente DESC'
    //     )
    //     ;
    //     return $query->getResult();
    // }

    // public function findAllAnnonce()
    // {
    //     return $this->createQueryBuilder('v')
    //         ->from('vente', 'v')
    //         ->Join('produit','p')
    //         ->Where('v.produit_id = p.id')
    //         ->orderBy('v.date_vente', 'DESC')
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

//    /**
//     * @return Vente[] Returns an array of Vente objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Vente
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
