<?php

namespace App\Repository;

use App\Entity\Superhero;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Superhero|null find($id, $lockMode = null, $lockVersion = null)
 * @method Superhero|null findOneBy(array $criteria, array $orderBy = null)
 * @method Superhero[]    findAll()
 * @method Superhero[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SuperheroRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Superhero::class);
    }

    public function transform(Superhero $superhero): array
    {
        return [
            'id'    => (int) $superhero->getId(),
            'name'  => (string) $superhero->getName(),
            'birth' => $superhero->getBirth()
        ];
    }

    public function transformAll(): array
    {
        $superheroes = $this->findAll();
        $superheroesArray = [];

        foreach ($superheroes as $superhero) {
            $superheroesArray[] = $this->transform($superhero);
        }

        return $superheroesArray;
    }
}
