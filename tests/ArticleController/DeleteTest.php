<?php

namespace Tests\ArticleController;

use App\Models\Article;
use Illuminate\Http\Response;
use Tests\TestCase;

class DeleteTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->article = Article::factory()->create();
    }

    public function testIf404IsBeingReturedWhenArticleIsNotFound()
    {
        $this->json('DELETE', "/articles/0", [])
            ->assertResponseStatus(Response::HTTP_NOT_FOUND);
    }

    public function testIfTheArticleIsBeingDeleted()
    {
        $this->json('DELETE', "/articles/{$this->article->id}")
            ->assertResponseOk();

        $this->notSeeInDatabase('articles', [
            $this->article->getKeyName() => $this->article->id,
            $this->article::DELETED_AT => null,
        ]);
    }

    public function tearDown(): void
    {
        $this->article->forceDelete();
        parent::tearDown();
    }
}
