<?php

namespace App\Repository;

use App\Entity\Commentaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Commentaire>
 *
 * @method Commentaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Commentaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Commentaire[]    findAll()
 * @method Commentaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Commentaire::class);
    }

    public function add(Commentaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Commentaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function mescommentairesrecette($utilisateur)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.utilisateur = :utilisateur_id')
            ->andWhere('c.recette IS NOT NULL')
            ->orderBy('c.date_commentaire', 'DESC')
            ->setParameter('utilisateur_id', $utilisateur)
            ->getQuery()
            ->getResult()
        ;
    }

    public function mescommentairessujet($utilisateur)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.utilisateur = :utilisateur_id')
            ->andWhere('c.sujet IS NOT NULL')
            ->orderBy('c.date_commentaire', 'DESC')
            ->setParameter('utilisateur_id', $utilisateur)
            ->getQuery()
            ->getResult()
        ;
    }

    // public function findLastPostscommentaire(int $nb = 10)
    // {
    //     return $this->createQueryBuilder('c')
    //         ->orderBy('c.date_commentaire', 'DESC')
    //         ->setMaxResults($nb)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

//    /**
//     * @return Commentaire[] Returns an array of Commentaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Commentaire
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
