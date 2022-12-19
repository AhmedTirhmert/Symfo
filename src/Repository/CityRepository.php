<?php

namespace App\Repository;

use App\Entity\City;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<City>
 *
 * @method City|null find($id, $lockMode = null, $lockVersion = null)
 * @method City|null findOneBy(array $criteria, array $orderBy = null)
 * @method City[]    findAll()
 * @method City[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private CountryRepository $countryRepository)
    {
        parent::__construct($registry, City::class);
        $this->countryRepository = $countryRepository;
    }

    public function save(City $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(City $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function updateCities()
    {
        try {
            $em = $this->getEntityManager();
            $conn = $this->getEntityManager()->getConnection();
            $sql = 'SELECT * FROM worldcities';
            $stmt = $conn->prepare($sql);
            $results = $stmt->executeQuery();
            foreach ($results->fetchAllAssociative() as $elem) {
                $population = $elem['population'] > 0 ? $elem['population'] : 0;
                $cityQ = $this->findBy(['name' => $elem['city']]);
                if (!count($cityQ)) {
                    $country = $this->countryRepository->findBy(['name' => $elem['country']]);
                    if (!count($country)) continue;
                    $city = new City();
                    $city->setName($elem['city']);
                    $city->setLatitude(floatval($elem['lat']));
                    $city->setLongitude(floatval($elem['lng']));
                    $city->setPopulation($population);
                    $city->setCountryId($country[0]);
                } else {
                    $city = $cityQ[0];
                    $city->setLatitude(floatval($elem['lat']));
                    $city->setLongitude(floatval($elem['lng']));
                    $city->setPopulation($population);
                }
                $em->persist($city);
                $em->flush();
            }
        } catch (\Throwable $th) {
            dd([
                $th->getMessage(),
                $elem
            ]);
        }
    }


    //    /**
    //     * @return City[] Returns an array of City objects
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

    //    public function findOneBySomeField($value): ?City
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
