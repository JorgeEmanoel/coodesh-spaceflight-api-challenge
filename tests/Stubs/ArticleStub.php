<?php

namespace Tests\Stubs;

use Tests\Contracts\StubContract;

class ArticleStub implements StubContract
{
    public function resolve(array $override = [], $ignore = [])
    {
        $data = array_merge([
            'title' => 'Lorem Ipsum',
            'url' => 'https://github.com/JorgeEmanoel/coodesh-spaceflight-api-challenge',
            'imageUrl' => 'https://avatars.githubusercontent.com/u/22504189?v=4',
            'newsSite' => 'https://github.com/JorgeEmanoel',
            'summary' => 'Lorem ipsum dolor sit amet adispiscing consectetur',
            'publishedAt' => '2022-01-08T19:22:46.000Z',
            'updatedAt' => '2022-01-08T19:32:48.251Z',
            'launches' => [],
            'events' => [],
        ], $override);

        foreach ($ignore as $key) {
            if (!isset($data[$key])) {
                continue;
            }

            unset($data[$key]);
        }

        return $data;
    }
}
