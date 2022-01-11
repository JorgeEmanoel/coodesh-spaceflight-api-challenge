<?php

namespace Tests\ArticleController;

use App\Models\Article;
use Illuminate\Http\Response;
use Tests\TestCase;

class IndexTest extends TestCase
{
    public function testIfEndpointIsActiveAndReturningTheRightJsonStructure()
    {
        $this->json('GET', '/articles')
            ->shouldReturnJson()
            ->seeStatusCode(Response::HTTP_OK)
            ->seeJsonStructure([
                'articles',
                'pages',
            ]);
    }

    /**
     * @depends testIfEndpointIsActiveAndReturningTheRightJsonStructure
     */
    public function testIfPaginationIsWorkingProperly()
    {
        Article::factory()->count(3)->create();

        $response = $this->call('GET', '/articles', [
            'page' => 1,
            'per_page' => 2,
        ]);

        $this->assertEquals(Response::HTTP_OK, $response->status());
        $content = json_decode($response->getContent(), true);

        $this->assertTrue(count($content['articles']) <= 2);
        $this->assertEquals($content['pages'], 2);
    }

    protected function tearDown(): void
    {
        Article::where(1)->forceDelete();
        parent::tearDown();
    }
}
