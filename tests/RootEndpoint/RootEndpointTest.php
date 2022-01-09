<?php

namespace Tests;

use Tests\TestCase;

final class RootEndpointTest extends TestCase
{
    const ROOT_ENPOINT_CONTENT = 'Back-end Challenge 2021 🏅 - Space Flight News';

    public function testIfTheCorrectTextIsBeingReturned()
    {
        $response = $this->call('GET', '/');

        $this->assertEquals(
            $response->getContent(),
            self::ROOT_ENPOINT_CONTENT
        );
    }
}
