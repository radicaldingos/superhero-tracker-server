<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Superhero;
use Doctrine\ORM\EntityManagerInterface;

class SuperheroDataPersister implements ContextAwareDataPersisterInterface
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof Superhero;
    }

    /**
     * @param Superhero $data
     * @param array $context
     */
    public function persist($data, array $context = []): void
    {
        $data->setBirth(new \DateTime());
        $this->em->persist($data);
        $this->em->flush();
    }

    public function remove($data, array $context = [])
    {
        $this->em->remove($data);
        $this->em->flush();
    }
}