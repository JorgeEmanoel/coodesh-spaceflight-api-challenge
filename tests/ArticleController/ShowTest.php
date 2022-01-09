<?php

namespace Tests\ArticleController;

use App\Models\Article;
use Illuminate\Http\Response;
use Tests\TestCase;

class ShowTest extends TestCase
{
    public function testIf404IsBeingReturedWhenNotArticleIsFound()
    {
        $this->json('GET', '/articles/0')
            ->shouldReturnJson()
            ->seeStatusCode(Response::HTTP_NOT_FOUND);
    }

    public function testIfAnArticleIsBeingReturnedWhenItDoesExist()
    {
        $article = Article::factory()->create();

        $this->json('GET', "/articles/$article->id")
            ->shouldReturnJson()
            ->seeStatusCode(Response::HTTP_OK)
            ->seeJsonStructure([
                'id',
                'featured',
                'title',
                'url',
                'imageUrl',
                'newsSite',
                'summary',
                'publishedAt',
                'launches',
                'events'
            ]);
    }

    protected function tearDown(): void
    {
        Article::where(1)->forceDelete();
        parent::tearDown();
    }
}
