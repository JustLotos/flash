<?php

declare(strict_types=1);

namespace App\Tests\Functional\Domain\Flash\Learner;

use App\DataFixtures\Flash\LearnerFixtures;
use App\Tests\AbstractTest;

class GetActionTest extends AbstractTest
{
    protected $method = 'GET';
    protected $uri = '/flash/learner/current/';

    public function getFixtures() : array
    {
        return [LearnerFixtures::class];
    }

    public function testValid() : void
    {
        $this->makeRequestWithAuth();
        self::assertResponseOk($this->response);
        self::assertArrayHasKey('id', $this->content);
        self::assertArrayHasKey('name', $this->content);
        self::assertArrayHasKey('first', $this->content['name']);
        self::assertArrayHasKey('last', $this->content['name']);

        self::assertIsString($this->content['id']);
        self::assertIsString($this->content['name']['first']);
        self::assertIsString($this->content['name']['last']);
    }
}
