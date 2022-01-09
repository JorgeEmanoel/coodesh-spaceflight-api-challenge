<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResouce;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ArticleController extends Controller
{
    protected $default_per_page = 10;

    public function index(Request $request)
    {
        $this->validate($request, [
            'page' => 'numeric|min:1',
            'per_page' => 'numeric|min:1',
        ]);

        $per_page = $request->per_page ?? $this->default_per_page;

        $articles = Article::query()
            ->paginate(
                $per_page,
                ['*'],
                'page',
                $request->page
            );

        return response([
            'articles' => ArticleResouce::collection($articles->items()),
            'pages' => ceil($articles->total() / $per_page),
        ]);
    }

    public function show($id)
    {
        $article = Article::find($id);

        if (!$article) {
            return response([], Response::HTTP_NOT_FOUND);
        }

        return response(new ArticleResouce($article));
    }
}
