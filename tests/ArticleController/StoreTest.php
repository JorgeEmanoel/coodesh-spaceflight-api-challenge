<?php

namespace Tests\ArticleController;

use App\Models\Article;
use Illuminate\Http\Response;
use Tests\Stubs\ArticleStub;
use Tests\TestCase;
use Tests\Traits\DataProviders\ArticleDataValidation;

class StoreTest extends TestCase
{
    use ArticleDataValidation;

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

    public function tearDown(): void
    {
        Article::where(1)->forceDelete();
        parent::tearDown();
    }
}
