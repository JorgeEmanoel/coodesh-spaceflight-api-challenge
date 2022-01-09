<?php

namespace Tests\Traits\DataProviders;

use Tests\Stubs\ArticleStub;

trait ArticleDataValidation
{
    public function typesBeingValidatedDataProvider()
    {
        $stub = new ArticleStub();

        return [
            /** Invalid Title, but rest is okay */
            [$stub->resolve([
                'title' => 0,
            ])],

            /** Invalid Url, but rest is okay */
            [$stub->resolve([
                'url' => 'this is not an url',
            ])],

            /** Invalid imageUrl, but rest is okay */
            [$stub->resolve([
                'imageUrl' => 'this is not an url either',
            ])],

            /** Invalid newsSite, but rest is okay */
            [$stub->resolve([
                'newsSite' => 0,
            ])],

            /** Invalid summary, but rest is okay */
            [$stub->resolve([
                'summary' => 0,
            ])],

            /** Invalid launches by missing provider, but rest is okay */
            [$stub->resolve([
                'launches' => [
                    'id' => '123',
                ],
            ])],

            /** Invalid launches by missing id, but rest is okay */
            [$stub->resolve([
                'launches' => [
                    'provider' => 'Some Random Provider',
                ],
            ])],

            /** Invalid events by missing proivder, but rest is okay */
            [$stub->resolve([
                'events' => [
                    [
                        'id' => '123',
                    ]
                ],
            ])],

            /** Invalid events by missing id, but rest is okay */
            [$stub->resolve([
                'events' => [
                    [
                        'provider' => 'Some Provider Without ID',
                    ]
                ],
            ])],

            /** Multiple invalid events by missing both, but rest is okay */
            [$stub->resolve([
                'events' => [
                    [
                        'provider' => 'Some Provider Without ID',
                    ],
                    [
                        'id' => '123',
                    ]
                ],
            ])],

            /** Multiple invalid lancuhes by missing both, but rest is okay */
            [$stub->resolve([
                'launches' => [
                    [
                        'provider' => 'Some Provider Without ID',
                    ],
                    [
                        'id' => '123',
                    ]
                ],
            ])],
        ];
    }
}
