<?php

declare(strict_types=1);

namespace App\Domain\Flash\Card\Entity\Types;

use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;
use JMS\Serializer\Annotation as Serializer;
use App\Domain\Flash\Card\Entity\Card;

class Id
{
    /** @var string */
    private $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value);
        $this->value = $value;
    }

    public static function next(): self
    {
        return new self(Uuid::uuid4()->toString());
    }

    /**
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName("id")
     * @Serializer\Groups({Card::GROUP_ONE})
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
