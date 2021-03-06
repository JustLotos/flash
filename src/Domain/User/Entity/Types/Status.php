<?php

declare(strict_types=1);

namespace App\Domain\User\Entity\Types;

use Doctrine\ORM\Mapping as ORM;
use DomainException;
use JMS\Serializer\Annotation as Serializer;
use Webmozart\Assert\Assert;

/**
 * @ORM\Embeddable
 */
class Status
{
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $value;

    public const STATUS_WAIT = 'WAIT';
    public const STATUS_ACTIVE = 'ACTIVE';
    public const STATUS_BLOCKED = 'BLOCKED';

    public function __construct(string $value)
    {
        Assert::oneOf($value, self::getAllStatus());
        $this->value = $value;
    }

    public static function createWait(): Status
    {
        return new self(self::STATUS_WAIT);
    }

    public function changeStatus(string $value) {
        Assert::oneOf($value, self::getAllStatus());
        $this->value = $value;
    }

    /**
     * @Serializer\VirtualProperty()
     * @Serializer\SerializedName("status")
     * @Serializer\Groups({App\Domain\User\Entity\User::GROUP_SIMPLE})
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public static function getAllStatus(): array
    {
        return [
            'Активирован' => self::STATUS_ACTIVE,
            'Заблокирован' => self::STATUS_BLOCKED,
            'Ожидает подтверждения' => self::STATUS_WAIT
        ];
    }

    public function isWait(): bool
    {
        return $this->value === self::STATUS_WAIT;
    }
    public function isActive(): bool
    {
        return $this->value === self::STATUS_ACTIVE;
    }
    public function isBlocked(): bool
    {
        return $this->value === self::STATUS_BLOCKED;
    }

    public function activate(): void
    {
        if ($this->isActive()) {
            throw new DomainException(json_encode(['status' => 'User is active.']));
        }

        $this->value = self::STATUS_ACTIVE;
    }
    public function block(): void
    {
        if ($this->isBlocked()) {
            throw new DomainException('User is already blocked.');
        }
        $this->value = self::STATUS_BLOCKED;
    }

    public function __toString(): string
    {
        return $this->getValue();
    }
}
