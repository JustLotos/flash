<?php

declare(strict_types=1);

namespace App\Domain\Flash\Card;

use App\Domain\Flash\Card\Entity\Card;
use App\Domain\Flash\Deck\Entity\Deck;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

class CardRepository extends ServiceEntityRepository
{
    /** @var EntityManager */
    private $manager;
    /** @var EntityRepository */
    private $repository;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Card::class);
        $this->manager = $em;
        $this->repository = $em->getRepository(Card::class);
    }

    public function findOneByDeck(Deck $deck)
    {
        return $this->repository->findBy(['deck' => $deck]);
    }

    /**
     * @param Card $card
     * @throws ORMException
     */
    public function add(Card $card)
    {
        $this->manager->persist($card);
    }

    /**
     * @param Card $deck
     * @throws ORMException
     */
    public function remove(Card $deck)
    {
        $this->manager->remove($deck);
    }
}
