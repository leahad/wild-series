<?php

namespace App\Repository;

use App\Entity\Episode;
use App\Entity\Program;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Program>
 *
 * @method Program|null find($id, $lockMode = null, $lockVersion = null)
 * @method Program|null findOneBy(array $criteria, array $orderBy = null)
 * @method Program[]    findAll()
 * @method Program[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProgramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Program::class);
    }

    public function save(Program $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Program $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Program[] Returns an array of Program objects
//     */
// public function CalculProgramDuration($program)
// {
//     return $this->createQueryBuilder('p')
//     ->select('SUM(episode.duration) AS EpisodesDuration')
//     ->andWhere('program.id = :program')
//     ->setParameter('program', $program)
//     ->join('season', 's')
//     ->where('p.id = s.p.id')
//     ->join('episode', 'e')
//     ->where('s.id = e.s.id')
//     ->GroupBy('p.id')
//     ->getQuery()
//     ->getOneOrNullResult()
//     ;
// }

//     public function CalculProgramDuration(int $program)
//     {
//     $conn = $this->getEntityManager()->getConnection();

//     $sql = '
//         SELECT SUM(episode.duration)
//         FROM program
//         JOIN season ON program.id = season.program_id
//         JOIN episode ON season.id = episode.season_id
//         GROUP BY program.id
//         ';
//     $stmt = $conn->prepare($sql);
//     $resultSet = $stmt->executeQuery(['program' => $program]);

//     return $resultSet->fetchOne();
// }

//    public function findOneBySomeField($value): ?Program
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
