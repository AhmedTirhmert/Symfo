<?php

namespace App\Repository;

use App\Entity\Stadium;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Stadium>
 *
 * @method Stadium|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stadium|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stadium[]    findAll()
 * @method Stadium[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StadiumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stadium::class);
    }

    public function save(Stadium $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Stadium $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    /**
     * @return League[] Returns an array of League objects
     */
    // public function stads(): array
    // {
    //     try {
    //         //code...
    //         $entityManager = $this->getEntityManager();

    //         $conn = $this->getEntityManager()->getConnection();
    //         $sql = 'SELECT * FROM football_stadiums';
    //         $stmt = $conn->prepare($sql);
    //         $stads = $stmt->executeQuery()->fetchAllAssociative();
    //         foreach ($stads as $stad) {
    //             $stadium = $this->findBy(['name' => $stad['Stadium']]);
    //             if (count($stadium)) continue;
    //             $country = $this->countryRepository->findBy(['name' => $stad['Country']]);
    //             if (!count($country)) continue;
    //             $city = $this->cityRepository->findBy(['name' => $stad['City'], 'country_id' => $country[0]->getId()]);
    //             if (!count($city)) {
    //                 $city = new City();
    //                 $city->setName($stad['City']);
    //                 $city->setCountryId($country[0]);
    //                 $entityManager->persist($city);
    //                 $entityManager->flush();
    //             }

    //             $city = $city instanceof City ? $city : $city[0];

    //             $stadium = new Stadium();
    //             $stadium->setName($stad['Stadium']);
    //             $stadium->setCapacity($stad['Capacity']);
    //             $stadium->setCityId($city);
    //             $entityManager->persist($stadium);
    //             $entityManager->flush();
    //         }
    //         dd('DONE');
    //     } catch (\Throwable $th) {
    //         dd([$th->getMessage(), $stadium]);
    //     }
    //     return [];
    // }

    //    /**
    //     * @return Stadium[] Returns an array of Stadium objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Stadium
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
