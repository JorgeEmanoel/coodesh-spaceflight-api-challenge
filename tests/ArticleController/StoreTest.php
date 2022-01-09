<?php

namespace tests\ArticleController;

use App\Models\Article;
use Illuminate\Http\Response;
use Tests\Stubs\ArticleStub;
use Tests\TestCase;

class StoreTest extends TestCase
{
    /**
     * @dataProvider typesBeingValidatedDataProvider
     */
    public function testIfTypesBeingValidated(array $data)
    {
        $this->json('POST', '/articles', $data)
            ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testIfItIsRecordingAFullyDataQualifiedArticle()
    {
        $stub = new ArticleStub();

        $this->json('POST', 'articles', $stub->resolve([
                'title' => 'Back-end Challenge 2021 🏅 - Space Flight News',
            ]))
            ->seeJsonContains($stub->resolve([
                'title' => 'Back-end Challenge 2021 🏅 - Space Flight News',
            ], ['publishedAt', 'updatedAt']))
            ->assertResponseStatus(Response::HTTP_CREATED);

        $this->seeInDatabase('articles', [
            'title' => 'Back-end Challenge 2021 🏅 - Space Flight News',
        ]);
    }

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

    public function tearDown(): void
    {
        Article::where(1)->forceDelete();
        parent::tearDown();
    }
}
