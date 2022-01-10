<?php

namespace Tests\ArticleController;

use App\Models\Article;
use Illuminate\Http\Response;
use Tests\TestCase;
use Tests\Traits\DataProviders\ArticleDataValidation;

class UpdateTest extends TestCase
{
    use ArticleDataValidation;

    public function setUp(): void
    {
        parent::setUp();
        $this->article = Article::factory()->create();
    }

    public function testIf404IsBeingReturedWhenNotArticleIsFound()
    {
        $this->json('PUT', "/articles/0", [])
            ->assertResponseStatus(Response::HTTP_NOT_FOUND);
    }


    /**
     * @dataProvider typesBeingValidatedDataProvider
     * @depends testIf404IsBeingReturedWhenNotArticleIsFound
     */
    public function testIfTypesBeingValidated(array $data)
    {
        $this->json('PUT', "/articles/{$this->article->id}", $data)
            ->assertResponseStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testIfDataIsBeingUpdated()
    {
        $this->json('PUT', "/articles/{$this->article->id}", [
                'title' => 'Lorem ipsum dolor sit amet',
            ])
            ->assertResponseOk();

        $this->seeInDatabase('articles', [
            $this->article->getKeyName() => $this->article->id,
            'title' => 'Lorem ipsum dolor sit amet',
        ]);
    }

    public function tearDown(): void
    {
        $this->article->forceDelete();
        parent::tearDown();
    }
}
