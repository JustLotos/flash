<?php

declare(strict_types=1);

namespace App\Domain\Flash\Learner\Entity\Types;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Embeddable
 */
class Name
{
    /**
     * @ORM\Column(type="string", nullable=true)
     * @Serializer\Type(name="string")
     */
    private $first;
    /**
     * @ORM\Column(type="string", nullable=true)
     * @Serializer\Type(name="string")
     */
    private $last;

    public function __construct(string $first ='Not specified', string $last = 'Not specified')
    {
        $this->first = $first;
        $this->last = $last;
    }

    public function getFirst(): string
    {
        return $this->first;
    }

    public function getLast(): string
    {
        return $this->last;
    }

    public function getFull(): string
    {
        return implode(' ', [
            $this->first,
            $this->last
        ]);
    }

    public function __toString(): string
    {
        return $this->getFull();
    }
}
